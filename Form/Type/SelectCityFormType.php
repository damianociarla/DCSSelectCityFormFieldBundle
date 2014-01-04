<?php

namespace DCS\Form\SelectCityFormFieldBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Doctrine\ORM\EntityRepository;
use DCS\Form\SelectCityFormFieldBundle\Model\SelectData;
use DCS\Form\SelectCityFormFieldBundle\Entity\Country;
use DCS\Form\SelectCityFormFieldBundle\Entity\State;

class SelectCityFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('country', 'entity', array(
                'empty_value'   => 'Select country',
                'class'         => 'DCSFormSelectCityFormFieldBundle:Country',
                'property'      => 'countryName',
                'required'      => $options['country_required'],
                'constraints'   => $this->getConstraints($options['country_required']),
            ))
        ;

        $refreshState = function (FormInterface $form, $country = null) use ($options) {
            if ($country instanceof Country) {
                $countryId = $country->getId();
            } elseif (is_numeric($country)) {
                $countryId = $country;
            } else {
                $countryId = 0;
            }
            $form->add('state', 'entity', array(
                'class'         => 'DCSFormSelectCityFormFieldBundle:State',
                'empty_value'   => 'Select state',
                'required'      => $options['state_required'],
                'constraints'   => $this->getConstraints($options['state_required']),
                'property'      => 'stateName',
                'query_builder' => function (EntityRepository $repository) use ($countryId) {
                    return $repository
                        ->createQueryBuilder('s')
                        ->innerJoin('DCSFormSelectCityFormFieldBundle:Country', 'c', \Doctrine\ORM\Query\Expr\Join::WITH, 's.countryCode = c.countryCode AND c.id = :c_id')
                        ->setParameter('c_id', $countryId)
                        ->orderBy('s.stateName', 'ASC');
                }
            ));
        };

        $refreshCity = function (FormInterface $form, $state = null) use ($options) {
            if ($state instanceof State) {
                $stateId = $state->getId();
            } elseif (is_numeric($state)) {
                $stateId = $state;
            } else {
                $stateId = 0;
            }
            $form->add('city', 'entity', array(
                'class'         => 'DCSFormSelectCityFormFieldBundle:City',
                'empty_value'   => 'Select city',
                'required'      => $options['city_required'],
                'constraints'   => $this->getConstraints($options['city_required']),
                'property'      => 'cityName',
                'query_builder' => function (EntityRepository $repository) use ($stateId) {
                    return $repository
                        ->createQueryBuilder('c')
                        ->innerJoin('DCSFormSelectCityFormFieldBundle:State', 's', \Doctrine\ORM\Query\Expr\Join::WITH, 'c.countryCode = s.countryCode AND c.stateCode = s.stateCode AND s.id = :s_id')
                        ->setParameter('s_id', $stateId)
                        ->orderBy('c.cityName', 'ASC');
                }
            ));
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($refreshState, $refreshCity) {
                $form = $event->getForm();
                $data = $event->getData();

                if ($data == null){
                    $refreshState($form, null);
                    $refreshCity($form, null);
                }

                if ($data instanceof SelectData) {
                    $refreshState($form, $data->getCountry());
                    $refreshCity($form, $data->getState());
                }
            }
        );

        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($refreshState, $refreshCity) {
                $form = $event->getForm();
                $data = $event->getData();

                if (isset($data['country']) && !empty($data['country']))
                    $refreshState($form, $data['country']);

                if (isset($data['state']) && !empty($data['state']))
                    $refreshCity($form, $data['state']);
            }
        );
    }

    private function getConstraints($required)
    {
        if ($required) {
            return array(
                new \Symfony\Component\Validator\Constraints\NotBlank(),
            );
        }

        return array();
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'        => 'DCS\Form\SelectCityFormFieldBundle\Model\SelectData',
            'country_required'  => true,
            'state_required'    => true,
            'city_required'     => true,
        ));

        $resolver->setAllowedTypes(array(
            'country_required'  => 'bool',
            'state_required'    => 'bool',
            'city_required'     => 'bool',
        ));
    }

    public function getName()
    {
        return 'select_city';
    }
}

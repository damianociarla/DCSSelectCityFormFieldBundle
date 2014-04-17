<?php

namespace DCS\Form\SelectCityFormFieldBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormView;
use DCS\Form\SelectCityFormFieldBundle\Model;

class SelectCityFormType extends AbstractType
{
    /**
     * @var Model\CountryManagerInterface
     */
    protected $countryManager;

    /**
     * @var Model\RegionManagerInterface
     */
    protected $regionManager;

    /**
     * @var Model\CityManagerInterface
     */
    protected $cityManager;

    public function __construct(
        Model\CountryManagerInterface $countryManager,
        Model\RegionManagerInterface $regionManager,
        Model\CityManagerInterface $cityManager
    ) {
        $this->countryManager = $countryManager;
        $this->regionManager = $regionManager;
        $this->cityManager = $cityManager;
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars = array_merge($view->vars, array(
            'callback_country'  => $options['callback_country'],
            'callback_region'   => $options['callback_region'],
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('country', 'entity', array(
                'label'         => 'form.label.country',
                'empty_value'   => 'form.label.country_empty',
                'class'         => $this->countryManager->getClass(),
                'property'      => 'countryName',
                'choices'       => $this->countryManager->findAll(),
                'required'      => $options['country_required'],
                'constraints'   => $this->getConstraints($options['country_required']),
            ))
        ;

        $regionManager = $this->regionManager;
        $cityManager = $this->cityManager;

        $refreshRegion = function (FormInterface $form, $countryId = null) use ($options, $regionManager) {
            $form->add('region', 'entity', array(
                'label'         => 'form.label.region',
                'empty_value'   => 'form.label.region_empty',
                'class'         => $regionManager->getClass(),
                'property'      => 'regionName',
                'choices'       => null === $countryId ? array() : $regionManager->findAllByCountryId($countryId),
                'required'      => $options['region_required'],
                'constraints'   => $this->getConstraints($options['region_required']),
            ));
        };

        $refreshCity = function (FormInterface $form, $regionId = null) use ($options, $cityManager) {
            $form->add('city', 'entity', array(
                'label'         => 'form.label.city',
                'empty_value'   => 'form.label.city_empty',
                'class'         => $cityManager->getClass(),
                'property'      => 'cityName',
                'choices'       => null === $regionId ? array() : $cityManager->findAllByRegionId($regionId),
                'required'      => $options['city_required'],
                'constraints'   => $this->getConstraints($options['city_required']),
            ));
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($refreshRegion, $refreshCity) {
                $form = $event->getForm();
                $data = $event->getData();

                $countryId = null;
                $regionId  = null;

                if ($data instanceof Model\SelectData) {
                    if (null !== $data->getCountry() && null !== $data->getCountry()->getId()) {
                        $countryId = $data->getCountry()->getId();
                    }
                    if (null !== $data->getRegion() && null !== $data->getRegion()->getId()) {
                        $regionId = $data->getRegion()->getId();
                    }
                }

                $refreshRegion($form, $countryId);
                $refreshCity($form, $regionId);
            }
        );

        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($refreshRegion, $refreshCity) {
                $form = $event->getForm();
                $data = $event->getData();

                if (isset($data['country']) && !empty($data['country']))
                    $refreshRegion($form, $data['country']);

                if (isset($data['region']) && !empty($data['region']))
                    $refreshCity($form, $data['region']);
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
            'data_class'            => 'DCS\Form\SelectCityFormFieldBundle\Model\SelectData',
            'translation_domain'    => 'DCSFormSelectCityFormFieldBundle',
            'country_required'      => true,
            'region_required'       => true,
            'city_required'         => true,
            'callback_country'      => 'callbackCountry',
            'callback_region'       => 'callbackRegion',
        ));

        $resolver->setAllowedTypes(array(
            'country_required'      => 'bool',
            'region_required'       => 'bool',
            'city_required'         => 'bool',
            'callback_country'      => 'string',
            'callback_region'       => 'string',
        ));
    }

    public function getName()
    {
        return 'select_city';
    }
}

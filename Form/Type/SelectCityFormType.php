<?php

namespace DCS\Form\SelectCityFormFieldBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
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

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('country', 'entity', array(
                'empty_value'   => 'Select country',
                'class'         => $this->countryManager->getClass(),
                'property'      => 'countryName',
                'choices'       => $this->countryManager->findAll(),
                'required'      => $options['country_required'],
                'constraints'   => $this->getConstraints($options['country_required']),
            ))
        ;

        $regionManager = $this->regionManager;
        $cityManager = $this->cityManager;

        $refreshRegion = function (FormInterface $form, $country = null) use ($options, $regionManager) {
            if ($country instanceof Country) {
                $countryId = $country->getId();
            } elseif (is_numeric($country)) {
                $countryId = $country;
            } else {
                $countryId = 0;
            }
            $form->add('region', 'entity', array(
                'empty_value'   => 'Select region',
                'class'         => $regionManager->getClass(),
                'property'      => 'regionName',
                'choices'       => $regionManager->findAllByCountryId($countryId),
                'required'      => $options['region_required'],
                'constraints'   => $this->getConstraints($options['region_required']),
            ));
        };

        $refreshCity = function (FormInterface $form, $region = null) use ($options, $cityManager) {
            if ($region instanceof Region) {
                $regionId = $region->getId();
            } elseif (is_numeric($region)) {
                $regionId = $region;
            } else {
                $regionId = 0;
            }
            $form->add('city', 'entity', array(
                'empty_value'   => 'Select city',
                'class'         => $cityManager->getClass(),
                'property'      => 'cityName',
                'choices'       => $cityManager->findAllByRegionId($regionId),
                'required'      => $options['city_required'],
                'constraints'   => $this->getConstraints($options['city_required']),
            ));
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($refreshRegion, $refreshCity) {
                $form = $event->getForm();
                $data = $event->getData();

                if ($data == null){
                    $refreshRegion($form, null);
                    $refreshCity($form, null);
                }

                if ($data instanceof Model\SelectData) {
                    $refreshRegion($form, $data->getCountry());
                    $refreshCity($form, $data->getRegion());
                }
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
            'data_class'        => 'DCS\Form\SelectCityFormFieldBundle\Model\SelectData',
            'country_required'  => true,
            'region_required'   => true,
            'city_required'     => true,
        ));

        $resolver->setAllowedTypes(array(
            'country_required'  => 'bool',
            'region_required'   => 'bool',
            'city_required'     => 'bool',
        ));
    }

    public function getName()
    {
        return 'select_city';
    }
}

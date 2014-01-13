DCSSelectCityFormFieldBundle
============================

The DCSSelectCityFormFieldBundle adds a new form field type `select_city` that renders three select (Country, Region, City) in your forms. Features include:

* Ajax support without the use of external libraries
* You can set a minimum security role to protect api
* At the submit of form you have a default object that represent the three select

## 1) Installation

### A) Download and install DCSSelectCityFormFieldBundle

To install DCSSelectCityFormFieldBundle run the following command

	bash $ php composer.phar require damianociarla/select-city-form-field-bundle

### B) Enable the bundle

Enable the required bundles in the kernel:

	<?php
	// app/AppKernel.php

	public function registerBundles()
	{
	    $bundles = array(
        	// ...
        	new DCS\Form\SelectCityFormFieldBundle\DCSFormSelectCityFormFieldBundle(),
    	);
	}

## 2) Create your Country, Region and City classes

In this first release DCSSelectCityFormFieldBundle supports only Doctrine ORM. However, you must provide a concrete Country, Region and City class.
You must extend the abstract entities provided by the bundle and creating the appropriate mappings.

### Country

    <?php
    // src/MyProject/MyBundle/Entity/Country.php

    namespace MyProject\MyBundle\Entity;

    use DCS\Form\SelectCityFormFieldBundle\Entity\Country as CountryBase;
    use Doctrine\ORM\Mapping as ORM;

    /**
     * @ORM\Entity
     */
    class Country extends CountryBase
    {
        /**
         * @ORM\Id
         * @ORM\Column(type="integer")
         * @ORM\GeneratedValue(strategy="AUTO")
         */
        protected $id;
    }

### Region

    <?php
    // src/MyProject/MyBundle/Entity/Region.php

    namespace MyProject\MyBundle\Entity;

    use DCS\Form\SelectCityFormFieldBundle\Entity\Region as RegionBase;
    use Doctrine\ORM\Mapping as ORM;

    /**
     * @ORM\Entity
     */
    class Region extends RegionBase
    {
        /**
         * @ORM\Id
         * @ORM\Column(type="integer")
         * @ORM\GeneratedValue(strategy="AUTO")
         */
        protected $id;
    }

### City

    <?php
    // src/MyProject/MyBundle/Entity/City.php

    namespace MyProject\MyBundle\Entity;

    use DCS\Form\SelectCityFormFieldBundle\Entity\City as CityBase;
    use Doctrine\ORM\Mapping as ORM;

    /**
     * @ORM\Entity
     */
    class City extends CityBase
    {
        /**
         * @ORM\Id
         * @ORM\Column(type="integer")
         * @ORM\GeneratedValue(strategy="AUTO")
         */
        protected $id;
    }

## 3) Configure your application

	# app/config/config.yml

    dcs_form_select_city_form_field:
        db_driver: orm
        api_security: IS_AUTHENTICATED_ANONYMOUSLY
        model:
            country: MyProject\MyBundle\Entity\Country
            region: MyProject\MyBundle\Entity\Region
            city: MyProject\MyBundle\Entity\City

## 4) Import DCSRatingBundle routing

Import the bundle routing:

    dcs_form_select_city_form_field:
        resource: "@DCSFormSelectCityFormFieldBundle/Resources/config/routing.xml"
        prefix:   /

## 5) Import javascript in your template

To import the javascript run the following command:

	bash $ php app/console assets:install

and include the javascript in your template:

	<script type="text/javascript" src="{{ asset('bundles/dcsformselectcityformfield/js/select_city.js') }}"></script>

## 6) Use the new form field

To include the new form field add a new field to builder object:

	$builder->add('address', 'select_city')
	
You have the following options:

	$builder->add('address', 'select_city', array(
		'country_required'  => true,
        'region_required'   => true,
        'city_required'     => true,
	))
	
## After submit

When the form is submitted the bundle provides an object that represent the three select. The object is: `DCS\Form\SelectCityFormFieldBundle\Model\SelectData`

## A complete example

Example of an entity and a form that represents the information returned by the new form field:

### Address entity

    <?php
	// src/MyProject/MyBundle/Entity/Address.php
	
    namespace MyProject\MyBundle\Entity;

    use Doctrine\ORM\Mapping as ORM;

    /**
     * @ORM\Entity
     */
    class Address
    {
        /**
         * @ORM\ManyToOne(targetEntity="MyProject\MyBundle\Entity\Country")
         * @ORM\JoinColumn(name="country_id", referencedColumnName="id", nullable=true)
         */
        protected $country;

        /**
         * @ORM\ManyToOne(targetEntity="MyProject\MyBundle\Entity\Region")
         * @ORM\JoinColumn(name="region_id", referencedColumnName="id", nullable=true)
         */
        protected $region;

        /**
         * @ORM\ManyToOne(targetEntity="MyProject\MyBundle\Entity\City")
         * @ORM\JoinColumn(name="city_id", referencedColumnName="id", nullable=true)
         */
        protected $city;

        /**
         * @var \DCS\Form\SelectCityFormFieldBundle\Model\SelectData
         */
        protected $selectData;

        /**
         * Set country
         *
         * @param \DCS\Form\SelectCityFormFieldBundle\Model\CountryInterface $country
         * @return Address
         */
        public function setCountry(\DCS\Form\SelectCityFormFieldBundle\Model\CountryInterface $country = null)
        {
            $this->country = $country;

            return $this;
        }

        /**
         * Get country
         *
         * @return \DCS\Form\SelectCityFormFieldBundle\Model\CountryInterface
         */
        public function getCountry()
        {
            return $this->country;
        }

        /**
         * Set region
         *
         * @param \DCS\Form\SelectCityFormFieldBundle\Model\RegionInterface $region
         * @return Address
         */
        public function setRegion(\DCS\Form\SelectCityFormFieldBundle\Model\RegionInterface $region = null)
        {
            $this->region = $region;

            return $this;
        }

        /**
         * Get region
         *
         * @return \DCS\Form\SelectCityFormFieldBundle\Model\RegionInterface
         */
        public function getRegion()
        {
            return $this->region;
        }

        /**
         * Set city
         *
         * @param \DCS\Form\SelectCityFormFieldBundle\Model\CityInterface $city
         * @return StandardAddress
         */
        public function setCity(\DCS\Form\SelectCityFormFieldBundle\Model\CityInterface $city = null)
        {
            $this->city = $city;

            return $this;
        }

        /**
         * Get city
         *
         * @return \DCS\Form\SelectCityFormFieldBundle\Model\CityInterface
         */
        public function getCity()
        {
            return $this->city;
        }

        /**
         * Set selectData
         *
         * @param \DCS\Form\SelectCityFormFieldBundle\Model\SelectData $selectData
         * @return Address
         */
        public function setSelectData(\DCS\Form\SelectCityFormFieldBundle\Model\SelectData $selectData)
        {
            $this->setCountry($selectData->getCountry());
            $this->setRegion($selectData->getRegion());
            $this->setCity($selectData->getCity());

            $this->selectData = $selectData;

            return $this;
        }

        /**
         * Get selectData
         *
         * @return \DCS\Form\SelectCityFormFieldBundle\Model\SelectData
         */
        public function getSelectData()
        {
            $selectData = new \DCS\Form\SelectCityFormFieldBundle\Model\SelectData();
            $selectData->setCountry($this->getCountry());
            $selectData->setRegion($this->getRegion());
            $selectData->setCity($this->getCity());

            return $selectData;
        }
    }
    
### Address form

    <?php
	// src/MyProject/MyBundle/Form/Type/Address.php
	
    namespace MyProject\MyBundle\Form\Type;

    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\OptionsResolver\OptionsResolverInterface;
    use Symfony\Component\Form\FormBuilderInterface;

    class AddressFormType extends AbstractType
    {
        public function buildForm(FormBuilderInterface $builder, array $options)
        {
            $builder
                ->add('selectData', 'select_city', array(
                    'country_required'  => $options['country_required'],
                    'state_required'    => $options['state_required'],
                    'city_required'     => $options['city_required'],
                ))
            ;
        }

        public function setDefaultOptions(OptionsResolverInterface $resolver)
        {
            $resolver->setDefaults(array(
                'data_class'                => 'MyProject\MyBundle\Entity\Address',
                'country_required'          => true,
                'state_required'            => true,
                'city_required'             => true,
            ));

            $resolver->setAllowedTypes(array(
                'country_required'          => 'bool',
                'state_required'            => 'bool',
                'city_required'             => 'bool',
            ));
        }

        public function getName()
        {
            return 'address';
        }
    }
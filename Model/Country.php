<?php

namespace DCS\Form\SelectCityFormFieldBundle\Model;

abstract class Country implements CountryInterface
{
    /**
     * Id auto-increment
     *
     * @var integer
     */
    protected $id;

    /**
     * Country code of 2 characters
     *
     * @var string
     */
    protected $countryCode;

    /**
     * Name of country
     *
     * @var string
     */
    protected $countryName;

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * {@inheritdoc}
     */
    public function getCountryName()
    {
        return $this->countryName;
    }
}

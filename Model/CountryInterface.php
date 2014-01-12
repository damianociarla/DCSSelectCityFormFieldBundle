<?php

namespace DCS\Form\SelectCityFormFieldBundle\Model;

interface CountryInterface
{
    /**
     * Get id
     *
     * @return integer
     */
    public function getId();

    /**
     * Get country code
     *
     * @return string
     */
    public function getCountryCode();

    /**
     * Get country name
     *
     * @return string
     */
    public function getCountryName();
}

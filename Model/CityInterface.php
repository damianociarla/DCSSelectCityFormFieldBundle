<?php

namespace DCS\Form\SelectCityFormFieldBundle\Model;

interface CityInterface
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
     * Get region code
     *
     * @return string
     */
    public function getRegionCode();

    /**
     * Get city name
     *
     * @return string
     */
    public function getCityName();
}

<?php

namespace DCS\Form\SelectCityFormFieldBundle\Model;

interface RegionInterface
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
     * Get region name
     *
     * @return string
     */
    public function getRegionName();
}

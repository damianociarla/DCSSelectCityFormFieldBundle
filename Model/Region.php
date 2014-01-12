<?php

namespace DCS\Form\SelectCityFormFieldBundle\Model;

abstract class Region implements RegionInterface
{
    /**
     * ID auto-increment
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
     * Region code
     *
     * @var string
     */
    protected $regionCode;

    /**
     * Name of region
     *
     * @var string
     */
    protected $regionName;

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
    public function getRegionCode()
    {
        return $this->regionCode;
    }

    /**
     * {@inheritdoc}
     */
    public function getRegionName()
    {
        return $this->regionName;
    }
}

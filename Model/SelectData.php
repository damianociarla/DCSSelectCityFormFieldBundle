<?php

namespace DCS\Form\SelectCityFormFieldBundle\Model;

class SelectData
{
    /**
     * @var CountryInterface
     */
    protected $country;

    /**
     * @var RegionInterface
     */
    protected $region;

    /**
     * @var CityInterface
     */
    protected $city;

    /**
     * Set country
     *
     * @param CountryInterface $country
     * @return SelectData
     */
    public function setCountry(CountryInterface $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return CountryInterface
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set region
     *
     * @param RegionInterface $region
     * @return SelectData
     */
    public function setRegion(RegionInterface $region = null)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return RegionInterface
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set city
     *
     * @param CityInterface $city
     * @return SelectData
     */
    public function setCity(CityInterface $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return CityInterface
     */
    public function getCity()
    {
        return $this->city;
    }
}

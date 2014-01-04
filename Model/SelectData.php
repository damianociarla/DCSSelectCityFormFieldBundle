<?php

namespace DCS\Form\SelectCityFormFieldBundle\Model;

class SelectData
{
    /**
     * @var \DCS\Form\SelectCityFormFieldBundle\Entity\Country
     */
    protected $country;

    /**
     * @var \DCS\Form\SelectCityFormFieldBundle\Entity\State
     */
    protected $state;

    /**
     * @var \DCS\Form\SelectCityFormFieldBundle\Entity\City
     */
    protected $city;

    /**
     * Set country
     *
     * @param \DCS\Form\SelectCityFormFieldBundle\Entity\Country $country
     * @return SelectData
     */
    public function setCountry(\DCS\Form\SelectCityFormFieldBundle\Entity\Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return \DCS\Form\SelectCityFormFieldBundle\Entity\Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set state
     *
     * @param \DCS\Form\SelectCityFormFieldBundle\Entity\State $state
     * @return SelectData
     */
    public function setState(\DCS\Form\SelectCityFormFieldBundle\Entity\State $state = null)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return \DCS\Form\SelectCityFormFieldBundle\Entity\State
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set city
     *
     * @param \DCS\Form\SelectCityFormFieldBundle\Entity\City $city
     * @return SelectData
     */
    public function setCity(\DCS\Form\SelectCityFormFieldBundle\Entity\City $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return \DCS\Form\SelectCityFormFieldBundle\Entity\City
     */
    public function getCity()
    {
        return $this->city;
    }
}

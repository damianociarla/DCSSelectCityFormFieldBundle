<?php

namespace DCS\Form\SelectCityFormFieldBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="DCS\Form\SelectCityFormFieldBundle\Repository\CityRepository")
 * @ORM\Table(name="cities", indexes={@ORM\Index(name="country_state_code_idx", columns={"country_code","state_code"})})
 */
class City
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="country_code", type="string", length=2)
     */
    protected $countryCode;

    /**
     * @ORM\Column(name="state_code", type="string", length=20)
     */
    protected $stateCode;

    /**
     * @ORM\Column(name="city_name", type="string", nullable=false)
     */
    protected $cityName;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get countryCode
     *
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * Get stateCode
     *
     * @return string
     */
    public function getStateCode()
    {
        return $this->stateCode;
    }

    /**
     * Get cityName
     *
     * @return string
     */
    public function getCityName()
    {
        return $this->cityName;
    }
}
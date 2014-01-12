<?php

namespace DCS\Form\SelectCityFormFieldBundle\Model;

use Doctrine\ORM\AbstractQuery;

interface CityManagerInterface extends BaseModelInterface
{
    /**
     * Find all cities filtered by regionId and returned as an array using HYDRATE_ARRAY method
     *
     * @param integer $regionId
     * @param integer $hydrateMode
     * @return array
     */
    public function findAllByRegionId($regionId, $hydrateMode = AbstractQuery::HYDRATE_OBJECT);
}

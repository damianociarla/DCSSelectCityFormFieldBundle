<?php

namespace DCS\Form\SelectCityFormFieldBundle\Model;

use Doctrine\ORM\AbstractQuery;

interface RegionManagerInterface extends BaseModelInterface
{
    /**
     * Find all regions filtered by countryId and returned as an array using HYDRATE_ARRAY method
     *
     * @param integer $regionId
     * @param integer $hydrateMode
     * @return array
     */
    public function findAllByCountryId($countryId, $hydrateMode = AbstractQuery::HYDRATE_OBJECT);

    /**
     * Find one region by id
     *
     * @param integer $id
     * @return RegionInterface
     */
    public function find($id);
}

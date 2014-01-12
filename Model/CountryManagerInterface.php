<?php

namespace DCS\Form\SelectCityFormFieldBundle\Model;

use Doctrine\ORM\AbstractQuery;

interface CountryManagerInterface extends BaseModelInterface
{
    /**
     * Get all countries as an 'array' using HYDRATE_ARRAY method
     *
     * @param integer $hydrateMode
     * @return array
     */
    public function findAll($hydrateMode = AbstractQuery::HYDRATE_OBJECT);

    /**
     * Find one country by id
     *
     * @param integer $id
     * @return CountryInterface
     */
    public function find($id);
}

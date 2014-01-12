<?php

namespace DCS\Form\SelectCityFormFieldBundle\Entity;

use Doctrine\ORM\AbstractQuery;
use DCS\Form\SelectCityFormFieldBundle\Model\CountryManager as BaseCountryManager;

class CountryManager extends BaseCountryManager
{
    /**
     * {@inheritdoc}
     */
    public function findAll($hydrateMode = AbstractQuery::HYDRATE_OBJECT)
    {
        $qb = $this->em->createQueryBuilder();
        $qb
            ->select('c')
            ->from($this->class, 'c')
        ;

        return $qb->getQuery()->getResult($hydrateMode);
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return $this->repository->find($id);
    }
}

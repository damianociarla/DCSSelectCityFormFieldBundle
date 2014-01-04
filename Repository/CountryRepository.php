<?php

namespace DCS\Form\SelectCityFormFieldBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CountryRepository extends EntityRepository
{
    public function findAllToArray()
    {
        $q = $this
            ->createQueryBuilder('c')
            ->getQuery()
        ;

        return $q->getResult(\Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY);
    }
}

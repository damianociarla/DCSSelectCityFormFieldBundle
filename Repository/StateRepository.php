<?php

namespace DCS\Form\SelectCityFormFieldBundle\Repository;

use Doctrine\ORM\EntityRepository;

class StateRepository extends EntityRepository
{
    public function findAllToArray($countryId)
    {
        $q = $this
            ->createQueryBuilder('s')
            ->innerJoin('DCSFormSelectCityFormFieldBundle:Country', 'c', \Doctrine\ORM\Query\Expr\Join::WITH, 's.countryCode = c.countryCode AND c.id = :c_id')
            ->setParameter('c_id', $countryId)
            ->orderBy('s.stateName', 'ASC')
            ->getQuery()
        ;

        return $q->getResult(\Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY);
    }
}

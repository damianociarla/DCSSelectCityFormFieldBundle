<?php

namespace DCS\Form\SelectCityFormFieldBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CityRepository extends EntityRepository
{
    public function findAllToArray($stateId)
    {
        $q = $this
            ->createQueryBuilder('c')
            ->innerJoin('DCSFormSelectCityFormFieldBundle:State', 's', \Doctrine\ORM\Query\Expr\Join::WITH, 'c.countryCode = s.countryCode AND c.stateCode = s.stateCode AND s.id = :s_id')
            ->setParameter('s_id', $stateId)
            ->orderBy('c.cityName', 'ASC')
            ->getQuery()
        ;

        return $q->getResult(\Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY);
    }
}

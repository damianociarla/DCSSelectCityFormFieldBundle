<?php

namespace DCS\Form\SelectCityFormFieldBundle\Entity;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\AbstractQuery;
use DCS\Form\SelectCityFormFieldBundle\Model\CityManager as BaseCityManager;

class CityManager extends BaseCityManager
{
    /**
     * @var string
     */
    protected $regionClass;

    public function __construct(EntityManager $em, $class, $regionClass)
    {
        parent::__construct($em, $class);
        $this->regionClass = $em->getClassMetadata($regionClass)->name;
    }

    /**
     * {@inheritdoc}
     */
    public function findAllByRegionId($regionId, $hydrateMode = AbstractQuery::HYDRATE_OBJECT)
    {
        $qb = $this->em->createQueryBuilder();
        $qb
            ->select('c')
            ->from($this->class, 'c')
            ->innerJoin($this->regionClass, 'r', \Doctrine\ORM\Query\Expr\Join::WITH, 'c.countryCode = r.countryCode AND c.regionCode = r.regionCode AND r.id = :r_id')
            ->setParameter('r_id', $regionId)
            ->orderBy('c.cityName', 'ASC')
        ;

        return $qb->getQuery()->getResult($hydrateMode);
    }
}

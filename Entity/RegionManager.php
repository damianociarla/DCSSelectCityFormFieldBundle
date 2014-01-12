<?php

namespace DCS\Form\SelectCityFormFieldBundle\Entity;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\AbstractQuery;
use DCS\Form\SelectCityFormFieldBundle\Model\RegionManager as BaseRegionManager;

class RegionManager extends BaseRegionManager
{
    /**
     * @var string
     */
    protected $countryClass;

    public function __construct(EntityManager $em, $class, $countryClass)
    {
        parent::__construct($em, $class);
        $this->countryClass = $em->getClassMetadata($countryClass)->name;
    }

    /**
     * {@inheritdoc}
     */
    public function findAllByCountryId($countryId, $hydrateMode = AbstractQuery::HYDRATE_OBJECT)
    {
        $qb = $this->em->createQueryBuilder();
        $qb
            ->select('r')
            ->from($this->class, 'r')
            ->innerJoin($this->countryClass, 'c', \Doctrine\ORM\Query\Expr\Join::WITH, 'r.countryCode = c.countryCode AND c.id = :c_id')
            ->setParameter('c_id', $countryId)
            ->orderBy('r.regionName', 'ASC')
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

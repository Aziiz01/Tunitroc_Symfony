<?php

namespace App\Repository;

use App\Entity\Echange;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EchangeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Echange::class);
    }
    
    public function countEchangesByState(string $state): int
    {
        $qb = $this->createQueryBuilder('e')
            ->select('COUNT(e)')
            ->where('e.etat = :etat')
            ->setParameter('etat', $state);

        return $qb->getQuery()->getSingleScalarResult();
    }
}

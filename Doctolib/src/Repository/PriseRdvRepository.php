<?php

namespace App\Repository;

use App\Entity\PriseRdv;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PriseRdv|null find($id, $lockMode = null, $lockVersion = null)
 * @method PriseRdv|null findOneBy(array $criteria, array $orderBy = null)
 * @method PriseRdv[]    findAll()
 * @method PriseRdv[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PriseRdvRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PriseRdv::class);
    }

    // /**
    //  * @return PriseRdv[] Returns an array of PriseRdv objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PriseRdv
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

<?php

namespace App\Repository;

use App\Entity\RateSeller;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RateSeller|null find($id, $lockMode = null, $lockVersion = null)
 * @method RateSeller|null findOneBy(array $criteria, array $orderBy = null)
 * @method RateSeller[]    findAll()
 * @method RateSeller[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RateSellerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RateSeller::class);
    }

    // /**
    //  * @return RateSeller[] Returns an array of RateSeller objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RateSeller
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

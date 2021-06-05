<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
      * @return Product[] Returns an array of Product objects
     */

    public function getEnabledAndVerifiedProducts(): array
    {
        return $this->createQueryBuilder('p')
            ->Where('p.verified = :verifiedProduct')
            ->andWhere('p.enabled = :enabledProduct')
            ->setParameter('verifiedProduct', true)
            ->setParameter('enabledProduct',true)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getEnabledAndVerifiedProduct($id): ?Product
    {
        return $this->createQueryBuilder('p')
            ->Where('p.verified = :verifiedProduct')
            ->andWhere('p.enabled = :enabledProduct')
            ->andWhere("p.id=:id")
            ->setParameter('verifiedProduct', true)
            ->setParameter('enabledProduct',true)
            ->setParameter('id', $id)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    /*
    public function findOneBySomeField($value): ?Product
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

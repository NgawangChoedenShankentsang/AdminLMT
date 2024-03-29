<?php

namespace App\Repository;

use App\Entity\Bexio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Bexio>
 *
 * @method Bexio|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bexio|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bexio[]    findAll()
 * @method Bexio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BexioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bexio::class);
    }

//    /**
//     * @return Bexio[] Returns an array of Bexio objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Bexio
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

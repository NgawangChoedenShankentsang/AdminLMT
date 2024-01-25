<?php

namespace App\Repository;

use App\Entity\Paid;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Paid>
 *
 * @method Paid|null find($id, $lockMode = null, $lockVersion = null)
 * @method Paid|null findOneBy(array $criteria, array $orderBy = null)
 * @method Paid[]    findAll()
 * @method Paid[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaidRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Paid::class);
    }

//    /**
//     * @return Paid[] Returns an array of Paid objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Paid
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

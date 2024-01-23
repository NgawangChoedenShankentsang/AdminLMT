<?php

namespace App\Repository;

use App\Entity\Licenses;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Licenses>
 *
 * @method Licenses|null find($id, $lockMode = null, $lockVersion = null)
 * @method Licenses|null findOneBy(array $criteria, array $orderBy = null)
 * @method Licenses[]    findAll()
 * @method Licenses[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LicensesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Licenses::class);
    }

//    /**
//     * @return Licenses[] Returns an array of Licenses objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Licenses
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

<?php

namespace App\Repository;

use App\Entity\Coworking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Coworking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Coworking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Coworking[]    findAll()
 * @method Coworking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoworkingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Coworking::class);
    }

    // /**
    //  * @return Coworking[] Returns an array of Coworking objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Coworking
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

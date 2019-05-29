<?php

namespace App\Repository;

use App\Entity\InterestProject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method InterestProject|null find($id, $lockMode = null, $lockVersion = null)
 * @method InterestProject|null findOneBy(array $criteria, array $orderBy = null)
 * @method InterestProject[]    findAll()
 * @method InterestProject[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InterestProjectRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, InterestProject::class);
    }

    // /**
    //  * @return InterestProject[] Returns an array of InterestProject objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?InterestProject
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

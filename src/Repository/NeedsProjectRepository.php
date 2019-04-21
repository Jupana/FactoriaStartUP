<?php

namespace App\Repository;

use App\Entity\NeedsProject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method NeedsProject|null find($id, $lockMode = null, $lockVersion = null)
 * @method NeedsProject|null findOneBy(array $criteria, array $orderBy = null)
 * @method NeedsProject[]    findAll()
 * @method NeedsProject[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NeedsProjectRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, NeedsProject::class);
    }

    // /**
    //  * @return NeedsProject[] Returns an array of NeedsProject objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NeedsProject
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

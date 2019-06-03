<?php

namespace App\Repository;

use App\Entity\InterestProfile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method InterestProfile|null find($id, $lockMode = null, $lockVersion = null)
 * @method InterestProfile|null findOneBy(array $criteria, array $orderBy = null)
 * @method InterestProfile[]    findAll()
 * @method InterestProfile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InterestProfileRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, InterestProfile::class);
    }

    // /**
    //  * @return InterestProfile[] Returns an array of InterestProfile objects
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
    public function findOneBySomeField($value): ?InterestProfile
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

<?php

namespace App\Repository;

use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Project::class);
    }

    // /**
    //  * @return Project[] Returns an array of Project objects
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
    public function findOneBySomeField($value): ?Project
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    //good query SELECT ( 6371 * acos( cos( radians(40.5089) ) * cos( radians( user_latitud ) ) * cos( radians( user_longitud ) - radians(-3.66544) ) + sin( radians(40.5089) ) * sin(radians(user_latitud)) ) ) AS distance  FROM     fsu_users  HAVING     distance < 25  ORDER BY     distance;
    public function findByDistance($lat,$long, $distance){
        return $this->createQueryBuilder('p')
            ->addSelect(
                '( 6371 * acos(cos(radians(' . $lat . '))' .
                    '* cos( radians( p.user_latitude ) )' .
                    '* cos( radians( p.user_longitude )' .
                    '- radians(' . $long . ') )' .
                    '+ sin( radians(' . $lat . ') )' .
                    '* sin( radians( p.user_latitude ) ) ) ) as distance'
            )
            ->having('distance < :distance')
            ->setParameter('distance', $distance)
            ->orderBy('distance', 'ASC')
            ->getQuery()
        ;
    }
}

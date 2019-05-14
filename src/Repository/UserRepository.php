<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use DoctrineExtensions\Query\Mysql\Acos;
use DoctrineExtensions\Query\Mysql\Cos;
use DoctrineExtensions\Query\Mysql\Sin;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
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
                    '* cos( radians( p.latitud ) )' .
                    '* cos( radians( p.longitud )' .
                    '- radians(' . $long . ') )' .
                    '+ sin( radians(' . $lat . ') )' .
                    '* sin( radians( p.latitud ) ) ) ) as distance'
            )
            ->having('distance < :distance')
            ->setParameter('distance', $distance)
            ->orderBy('distance', 'ASC')
            ->getQuery()
            ->getResult();
        ;
    }
}

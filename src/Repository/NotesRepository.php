<?php

namespace App\Repository;

use App\Entity\Notes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Notes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notes[]    findAll()
 * @method Notes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Notes::class);
    }

    // /**
    //  * @return Notes[] Returns an array of Notes objects
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
    public function findOneBySomeField($value): ?Notes
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findNote($id,$user)
    {
        $qb= $this->createQueryBuilder('n');
        $qb ->andWhere('n.user = :user')
            ->andWhere('n.interest_profile = :id')
            ->orWhere('n.interest_project = :id')
            ->setParameter('id', $id)
            ->setParameter('user', $user);

        $qb =$qb->getQuery();
        return $qb->getResult();
    }

    public function findNotes($userId)
    {
        $qb= $this->createQueryBuilder('n');
        $qb ->andWhere('n.user = :userid')           
            ->groupBy('n.notes_uniq_id')
            ->orderBy('n.notes_date', 'DESC') 
            ->setParameter('userid', $userId);

        $qb =$qb->getQuery();
        return $qb->getResult();
    }
}

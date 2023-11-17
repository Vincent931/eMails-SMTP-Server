<?php

namespace App\Repository;

use App\Entity\IdentifiantMailing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method IdentifiantMailing|null find($id, $lockMode = null, $lockVersion = null)
 * @method IdentifiantMailing|null findOneBy(array $criteria, array $orderBy = null)
 * @method IdentifiantMailing[]    findAll()
 * @method IdentifiantMailing[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IdentifiantMailingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IdentifiantMailing::class);
    }

    public function findAll()
    {
        return $this->createQueryBuilder('i')
            ->orderBy('i.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    // /**
    //  * @return IdentifiantMailing[] Returns an array of IdentifiantMailing objects
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
    public function findOneBySomeField($value): ?IdentifiantMailing
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

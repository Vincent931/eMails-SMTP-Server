<?php

namespace App\Repository;

use App\Entity\BaseEmail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
/**
 * @method BaseEmail|null find($id, $lockMode = null, $lockVersion = null)
 * @method BaseEmail|null findOneBy(array $criteria, array $orderBy = null)
 * @method BaseEmail[]    findAll()
 * @method BaseEmail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BaseEmailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BaseEmail::class);
    }

    public function findAll()
    {
        return $this->createQueryBuilder('n')
            ->orderBy('n.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    public function findByLimits($value1, $value2)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.number >= :val1')
            ->andWhere('b.number <= :val2')
            ->setParameter('val1', $value1)
            ->setParameter('val2', $value2)
            ->orderBy('b.number', 'ASC')
            ->setMaxResults(1000001)
            ->getQuery()
            ->getResult()
        ;
    }
    public function findByAdresse($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.adresse = :val')
            ->setParameter('val', $value)
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }
    // /**
    //  * @return BaseEmail[] Returns an array of BaseEmail objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BaseEmail
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

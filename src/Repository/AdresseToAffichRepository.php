<?php

namespace App\Repository;

use App\Entity\AdresseToAffich;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AdresseToAffich>
 *
 * @method AdresseToAffich|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdresseToAffich|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdresseToAffich[]    findAll()
 * @method AdresseToAffich[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdresseToAffichRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdresseToAffich::class);
    }

    public function save(AdresseToAffich $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AdresseToAffich $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function findAll()
    {
        return $this->createQueryBuilder('b')
            ->orderBy('b.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
//    /**
//     * @return AdresseToAffich[] Returns an array of AdresseToAffich objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AdresseToAffich
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

<?php

namespace App\Repository;

use App\Entity\UserHasProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserHasProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserHasProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserHasProduct[]    findAll()
 * @method UserHasProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserHasProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserHasProduct::class);
    }

    // /**
    //  * @return UserHasProduct[] Returns an array of UserHasProduct objects
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
    public function findOneBySomeField($value): ?UserHasProduct
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

<?php

namespace App\Repository;

use App\Entity\Inspiration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Inspiration|null find($id, $lockMode = null, $lockVersion = null)
 * @method Inspiration|null findOneBy(array $criteria, array $orderBy = null)
 * @method Inspiration[]    findAll()
 * @method Inspiration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InspirationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Inspiration::class);
    }

//    /**
//     * @return Inspiration[] Returns an array of Inspiration objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('y')
            ->andWhere('y.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('y.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Inspiration
    {
        return $this->createQueryBuilder('y')
            ->andWhere('y.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

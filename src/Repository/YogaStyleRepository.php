<?php

namespace App\Repository;

use App\Entity\YogaStyle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method YogaStyle|null find($id, $lockMode = null, $lockVersion = null)
 * @method YogaStyle|null findOneBy(array $criteria, array $orderBy = null)
 * @method YogaStyle[]    findAll()
 * @method YogaStyle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class YogaStyleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, YogaStyle::class);
    }

//    /**
//     * @return YogaStyle[] Returns an array of YogaStyle objects
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
    public function findOneBySomeField($value): ?YogaStyle
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

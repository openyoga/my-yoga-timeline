<?php

namespace App\Repository;

use App\Entity\Workshop;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Workshop|null find($id, $lockMode = null, $lockVersion = null)
 * @method Workshop|null findOneBy(array $criteria, array $orderBy = null)
 * @method Workshop[]    findAll()
 * @method Workshop[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkshopRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Workshop::class);
    }

    public function findAllJoinedDetails()
    {
        return $this->createQueryBuilder('w')
            // YogaStyle
            ->innerJoin('w.yogaStyle', 'y')
            ->addSelect('y')
            // Location
            ->innerJoin('w.location', 'l')
            ->addSelect('l')
            // Inspiration
            ->leftJoin('w.inspiration', 'i')
            ->addSelect('i')
            // order
            ->orderBy('w.plannedDate', 'DESC')
            // get result
            ->getQuery()
            ->getResult();
    }

    public function findUpcomingJoinedDetails()
    {
        $yesterday = new \DateTime("now");
        $yesterday->modify('-1 day');
        return $this->createQueryBuilder('w')
            // YogaStyle
            ->innerJoin('w.yogaStyle', 'y')
            ->addSelect('y')
            // Location
            ->innerJoin('w.location', 'l')
            ->addSelect('l')
            // Inspiration
            ->leftJoin('w.inspiration', 'i')
            ->addSelect('i')
            // bind parameter
            ->andWhere('w.plannedDate > :yesterday')
            ->setParameter('yesterday', $yesterday)
            // order
            ->orderBy('w.plannedDate', 'ASC')
            // get result
            ->getQuery()
            ->getResult();
    }

    public function findOneByIdJoinedDetails($workshopId)
    {
        return $this->createQueryBuilder('w')
            // YogaStyle
            ->innerJoin('w.yogaStyle', 'y')
            ->addSelect('y')
            // Location
            ->innerJoin('w.location', 'l')
            ->addSelect('l')
            // Inspiration
            ->innerJoin('w.inspiration', 'i')
            ->addSelect('i')
            // bind parameter
            ->andWhere('w.id = :id')
            ->setParameter('id', $productId)
            ->getQuery()
            ->getOneOrNullResult();
    }

//    /**
//     * @return Workshop[] Returns an array of Workshop objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Workshop
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

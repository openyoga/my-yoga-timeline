<?php

namespace App\Repository;

use App\Entity\WorkshopParticipant;
use App\Entity\Workshop;
use App\Entity\Participant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method WorkshopParticipant|null find($id, $lockMode = null, $lockVersion = null)
 * @method WorkshopParticipant|null findOneBy(array $criteria, array $orderBy = null)
 * @method WorkshopParticipant[]    findAll()
 * @method WorkshopParticipant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkshopParticipantRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, WorkshopParticipant::class);
    }

//    /**
//     * @return WorkshopParticipant[] Returns an array of WorkshopParticipant objects
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
    public function findOneBySomeField($value): ?WorkshopParticipant
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

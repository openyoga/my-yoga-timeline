<?php

namespace App\Repository;

use App\Entity\Payment;
use App\Entity\PaymentParticipant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Payment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Payment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Payment[]    findAll()
 * @method Payment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaymentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Payment::class);
    }

    public function findAllJoinedDetails()
    {
        return $this->createQueryBuilder('pay')
            // Participant
            ->innerJoin('pay.participant', 'par')
            ->addSelect('par')
            // order
            ->orderBy('pay.receiptDate', 'DESC')
            ->orderBy('par.firstName', 'ASC')
            ->orderBy('par.lastName', 'ASC')
            // get result
            ->getQuery()
            ->getResult();
    }

    public function findOneByIdJoinedDetails($paymentId)
    {
        return $this->createQueryBuilder('pay')
            // Participant
            ->innerJoin('pay.participant', 'par')
            ->addSelect('par')
            // bind parameter
            ->andWhere('pay.id = :id')
            ->setParameter('id', $paymentId)
            ->getQuery()
            ->getOneOrNullResult();
    }

//    /**
//     * @return Payment[] Returns an array of Payment objects
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
    public function findOneBySomeField($value): ?Payment
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

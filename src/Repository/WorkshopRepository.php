<?php

namespace App\Repository;

use App\Entity\Workshop;
use App\Entity\WorkshopParticipant;
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
        $nowMinus24Hours = new \DateTime("now");
        $nowMinus24Hours->modify('-24 hour');
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
            ->andWhere('w.plannedDate > :nowMinus24Hours')
            ->setParameter('nowMinus24Hours', $nowMinus24Hours)
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
            ->leftJoin('w.inspiration', 'i')
            ->addSelect('i')
            // bind parameter
            ->andWhere('w.id = :id')
            ->setParameter('id', $workshopId)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findParticipantsByWorkshopId($workshopId)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
            SELECT 
                p.*,
                wp.special_fee,
                wp.fee_payed_yn,
                wp.attending_yn
            FROM 
                workshops_participants wp
                join participants p ON wp.participant_id = p.id
            WHERE 
                wp.workshop_id = :workshop_id
            ORDER BY 
                p.first_name ASC,
                p.last_name ASC
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['workshop_id' => $workshopId]);
        return $stmt->fetchAll();
    }

    public function findAvailableParticipantsByWorkshopId($workshopId)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
            SELECT 
                p.*
            FROM 
                participants p
            WHERE 
                p.id not in (
                    SELECT 
                        participant_id
                    FROM
                        workshops_participants
                    WHERE
                        workshop_id = :workshop_id
                )
            ORDER BY 
                p.first_name ASC,
                p.last_name ASC
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['workshop_id' => $workshopId]);
        return $stmt->fetchAll();
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

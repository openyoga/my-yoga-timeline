<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\EventParticipant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function findAllJoinedDetails()
    {
        return $this->createQueryBuilder('e')
            // EventCategory
            ->innerJoin('e.category', 'ec')
            ->addSelect('ec')
            // Location
            ->innerJoin('e.location', 'l')
            ->addSelect('l')
            // Inspiration
            ->leftJoin('e.inspiration', 'i')
            ->addSelect('i')
            // order
            ->orderBy('e.plannedDate', 'DESC')
            // get result
            ->getQuery()
            ->getResult();
    }

    public function findUpcomingJoinedDetails()
    {
        $nowMinus24Hours = new \DateTime("now");
        $nowMinus24Hours->modify('-24 hour');
        return $this->createQueryBuilder('e')
            // EventCategory
            ->innerJoin('e.category', 'ec')
            ->addSelect('ec')
            // Location
            ->innerJoin('e.location', 'l')
            ->addSelect('l')
            // Inspiration
            ->leftJoin('e.inspiration', 'i')
            ->addSelect('i')
            // bind parameter
            ->andWhere('e.plannedDate > :nowMinus24Hours')
            ->setParameter('nowMinus24Hours', $nowMinus24Hours)
            // order
            ->orderBy('e.plannedDate', 'ASC')
            // get result
            ->getQuery()
            ->getResult();
    }

    public function findOneByIdJoinedDetails($eventId)
    {
        return $this->createQueryBuilder('e')
            // EventCategory
            ->innerJoin('e.category', 'ec')
            ->addSelect('ec')
            // Location
            ->innerJoin('e.location', 'l')
            ->addSelect('l')
            // Inspiration
            ->leftJoin('e.inspiration', 'i')
            ->addSelect('i')
            // bind parameter
            ->andWhere('e.id = :id')
            ->setParameter('id', $eventId)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findParticipantsByEventId($eventId)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
            SELECT 
                p.*,
                ep.special_fee,
                ep.attending_yn
            FROM 
                events_participants ep
                join participants p ON ep.participant_id = p.id
            WHERE 
                ep.event_id = :event_id
            ORDER BY 
                p.first_name ASC,
                p.last_name ASC
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['event_id' => $eventId]);
        return $stmt->fetchAll();
    }

    public function findAvailableParticipantsByEventId($eventId)
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
                        events_participants
                    WHERE
                        event_id = :event_id
                )
            ORDER BY 
                p.first_name ASC,
                p.last_name ASC
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['event_id' => $eventId]);
        return $stmt->fetchAll();
    }

//    /**
//     * @return Event[] Returns an array of Event objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Event
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

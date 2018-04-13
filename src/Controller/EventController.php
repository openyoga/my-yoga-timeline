<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Event;
use App\Entity\EventParticipant;
use App\Entity\Participant;
use App\Form\EventType;

/**
 * @Route("/events")
 */
class EventController extends Controller
{
    /**
     * @Route("/", name="event_index")
     * @Method({"GET"})
     */
    public function index()
    {
        $events = $this->getDoctrine()->getRepository(Event::class)->findAllJoinedDetails();        
        return $this->render('events/index.html.twig', array(
            'events' => $events
        ));
    }

    /**
     * @Route("/new", name="event_new")
     * @Method({"GET", "POST"})
     */
    public function new(Request $request)
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();
            return $this->redirectToRoute('event_index');
        }

        return $this->render('events/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}/edit/{backToRoute}", requirements={"id": "\d+"}, name="event_edit")
     * @Method({"GET", "POST"})
     */
    public function edit(Request $request, Event $event, $backToRoute)
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();
            //$this->addFlash('success', 'event.updated_successfully');
            return $this->redirectToRoute($backToRoute);
        }

        return $this->render('events/edit.html.twig', array(
            'event' => $event,
            'form' => $form->createView(),
            'backToRoute' => $backToRoute,
            'backToUrl' => $this->generateUrl($backToRoute)
        ));
    }

    /**
     * @Route("/{id}/manage_participants/{backToRoute}", requirements={"id": "\d+"}, name="event_manage_participants")
     * @Method({"GET", "POST"})
     */
    public function manage_participants(Request $request, Event $event, $backToRoute)
    {
        $eventDetails = $this->getDoctrine()->getRepository(Event::class)
            ->findOneByIdJoinedDetails($event->getId());
        $participants = $this->getDoctrine()->getRepository(Event::class)
            ->findParticipantsByEventId($event->getId());
        $availableAarticipants = $this->getDoctrine()->getRepository(Event::class)
            ->findAvailableParticipantsByEventId($event->getId());
        return $this->render('events/manage_participants.html.twig', array(
            'event' => $eventDetails,
            'participants' => $participants,
            'availableAarticipants' => $availableAarticipants,
            'backToRoute' => $backToRoute,
            'backToUrl' => $this->generateUrl($backToRoute)
        ));
    }

    /**
     * @Route("/{id}/add_participant/{participantId}/{backToRoute}", requirements={"id": "\d+", "participantId": "\d+"}, name="event_add_participant")
     * @Method({"GET"})
     */
    public function add_participant(Request $request, Event $event, $participantId, $backToRoute)
    {
        $participant = $this->getDoctrine()->getRepository(Participant::class)->find($participantId);

        $eventParticipant = new EventParticipant();
        $eventParticipant->setEvent($event);
        $eventParticipant->setParticipant($participant);
        $eventParticipant->setFeePayedYn('N');
        $eventParticipant->setAttendingYn('Y');

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($eventParticipant);
        $entityManager->flush();

        return $this->redirectToRoute('event_manage_participants', array(
            'id' => $event->getId(),
            'backToRoute' => $backToRoute
        ));
    }

    /**
     * @Route("/{id}/remove_participant/{participantId}/{backToRoute}", requirements={"id": "\d+", "participantId": "\d+"}, name="event_remove_participant")
     * @Method({"GET"})
     */
    public function remove_participant(Request $request, Event $event, $participantId, $backToRoute)
    {
        $participant = $this->getDoctrine()->getRepository(Participant::class)->find($participantId);

        $eventParticipant = $this->getDoctrine()->getRepository(EventParticipant::class)->findOneBy(array (
            'event' => $event->getId(),
            'participant' => $participantId
        ));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($eventParticipant);
        $entityManager->flush();

        return $this->redirectToRoute('event_manage_participants', array(
            'id' => $event->getId(),
            'backToRoute' => $backToRoute
        ));
    }

    /**
     * @Route("/{id}/toggle_payed_status/{participantId}/{backToRoute}", requirements={"id": "\d+", "participantId": "\d+"}, name="toggle_payed_status")
     * @Method({"GET"})
     */
    public function toggle_payed_status(Request $request, Event $event, $participantId, $backToRoute)
    {
        $participant = $this->getDoctrine()->getRepository(Participant::class)->find($participantId);

        $eventParticipant = $this->getDoctrine()->getRepository(EventParticipant::class)->findOneBy(array (
            'event' => $event->getId(),
            'participant' => $participantId
        ));
        if ($eventParticipant->getFeePayedYn() == 'N') {
            $eventParticipant->setFeePayedYn('Y');
        }
        else {
            $eventParticipant->setFeePayedYn('N');
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($eventParticipant);
        $entityManager->flush();

        return $this->redirectToRoute('event_manage_participants', array(
            'id' => $event->getId(),
            'backToRoute' => $backToRoute
        ));
    }

    /**
     * @Route("/{id}/toggle_attending_status/{participantId}/{backToRoute}", requirements={"id": "\d+", "participantId": "\d+"}, name="toggle_attending_status")
     * @Method({"GET"})
     */
    public function toggle_attending_status(Request $request, Event $event, $participantId, $backToRoute)
    {
        $participant = $this->getDoctrine()->getRepository(Participant::class)->find($participantId);

        $eventParticipant = $this->getDoctrine()->getRepository(EventParticipant::class)->findOneBy(array (
            'event' => $event->getId(),
            'participant' => $participantId
        ));
        if ($eventParticipant->getAttendingYn() == 'N') {
            $eventParticipant->setAttendingYn('Y');
        }
        else {
            $eventParticipant->setAttendingYn('N');
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($eventParticipant);
        $entityManager->flush();

        return $this->redirectToRoute('event_manage_participants', array(
            'id' => $event->getId(),
            'backToRoute' => $backToRoute
        ));
    }

}

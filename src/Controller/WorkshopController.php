<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Workshop;
use App\Entity\WorkshopParticipant;
use App\Entity\Participant;
use App\Form\WorkshopType;

/**
 * @Route("/workshops")
 */
class WorkshopController extends Controller
{
    /**
     * @Route("/", name="workshop_index")
     * @Method({"GET"})
     */
    public function index()
    {
        $workshops = $this->getDoctrine()->getRepository(Workshop::class)->findAllJoinedDetails();        
        return $this->render('workshops/index.html.twig', array(
            'workshops' => $workshops
        ));
    }

    /**
     * @Route("/new", name="workshop_new")
     * @Method({"GET", "POST"})
     */
    public function new(Request $request)
    {
        $workshop = new Workshop();
        $form = $this->createForm(WorkshopType::class, $workshop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $workshop = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($workshop);
            $entityManager->flush();
            return $this->redirectToRoute('workshop_index');
        }

        return $this->render('workshops/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}/edit/{backToRoute}", requirements={"id": "\d+"}, name="workshop_edit")
     * @Method({"GET", "POST"})
     */
    public function edit(Request $request, Workshop $workshop, $backToRoute)
    {
        $form = $this->createForm(WorkshopType::class, $workshop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $workshop = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($workshop);
            $entityManager->flush();
            //$this->addFlash('success', 'workshop.updated_successfully');
            return $this->redirectToRoute($backToRoute);
        }

        return $this->render('workshops/edit.html.twig', array(
            'workshop' => $workshop,
            'form' => $form->createView(),
            'backToRoute' => $backToRoute,
            'backToUrl' => $this->generateUrl($backToRoute)
        ));
    }

    /**
     * @Route("/{id}/manage_participants/{backToRoute}", requirements={"id": "\d+"}, name="workshop_manage_participants")
     * @Method({"GET", "POST"})
     */
    public function manage_participants(Request $request, Workshop $workshop, $backToRoute)
    {
        $workshopDetails = $this->getDoctrine()->getRepository(Workshop::class)
            ->findOneByIdJoinedDetails($workshop->getId());
        $participants = $this->getDoctrine()->getRepository(Workshop::class)
            ->findParticipantsByWorkshopId($workshop->getId());
        $availableAarticipants = $this->getDoctrine()->getRepository(Workshop::class)
            ->findAvailableParticipantsByWorkshopId($workshop->getId());
        return $this->render('workshops/manage_participants.html.twig', array(
            'workshop' => $workshopDetails,
            'participants' => $participants,
            'availableAarticipants' => $availableAarticipants,
            'backToRoute' => $backToRoute,
            'backToUrl' => $this->generateUrl($backToRoute)
        ));
    }

    /**
     * @Route("/{id}/add_participant/{participantId}/{backToRoute}", requirements={"id": "\d+", "participantId": "\d+"}, name="workshop_add_participant")
     * @Method({"GET"})
     */
    public function add_participant(Request $request, Workshop $workshop, $participantId, $backToRoute)
    {
        $participant = $this->getDoctrine()->getRepository(Participant::class)->find($participantId);

        $workshopParticipant = new WorkshopParticipant();
        $workshopParticipant->setWorkshop($workshop);
        $workshopParticipant->setParticipant($participant);
        $workshopParticipant->setFeePayedYn('N');
        $workshopParticipant->setAttendingYn('Y');

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($workshopParticipant);
        $entityManager->flush();

        return $this->redirectToRoute('workshop_manage_participants', array(
            'id' => $workshop->getId(),
            'backToRoute' => $backToRoute
        ));
    }

    /**
     * @Route("/{id}/remove_participant/{participantId}/{backToRoute}", requirements={"id": "\d+", "participantId": "\d+"}, name="workshop_remove_participant")
     * @Method({"GET"})
     */
    public function remove_participant(Request $request, Workshop $workshop, $participantId, $backToRoute)
    {
        $participant = $this->getDoctrine()->getRepository(Participant::class)->find($participantId);

        $workshopParticipant = $this->getDoctrine()->getRepository(WorkshopParticipant::class)->findOneBy(array (
            'workshop' => $workshop->getId(),
            'participant' => $participantId
        ));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($workshopParticipant);
        $entityManager->flush();

        return $this->redirectToRoute('workshop_manage_participants', array(
            'id' => $workshop->getId(),
            'backToRoute' => $backToRoute
        ));
    }

    /**
     * @Route("/{id}/toggle_payed_status/{participantId}/{backToRoute}", requirements={"id": "\d+", "participantId": "\d+"}, name="toggle_payed_status")
     * @Method({"GET"})
     */
    public function toggle_payed_status(Request $request, Workshop $workshop, $participantId, $backToRoute)
    {
        $participant = $this->getDoctrine()->getRepository(Participant::class)->find($participantId);

        $workshopParticipant = $this->getDoctrine()->getRepository(WorkshopParticipant::class)->findOneBy(array (
            'workshop' => $workshop->getId(),
            'participant' => $participantId
        ));
        if ($workshopParticipant->getFeePayedYn() == 'N') {
            $workshopParticipant->setFeePayedYn('Y');
        }
        else {
            $workshopParticipant->setFeePayedYn('N');
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($workshopParticipant);
        $entityManager->flush();

        return $this->redirectToRoute('workshop_manage_participants', array(
            'id' => $workshop->getId(),
            'backToRoute' => $backToRoute
        ));
    }

    /**
     * @Route("/{id}/toggle_attending_status/{participantId}/{backToRoute}", requirements={"id": "\d+", "participantId": "\d+"}, name="toggle_attending_status")
     * @Method({"GET"})
     */
    public function toggle_attending_status(Request $request, Workshop $workshop, $participantId, $backToRoute)
    {
        $participant = $this->getDoctrine()->getRepository(Participant::class)->find($participantId);

        $workshopParticipant = $this->getDoctrine()->getRepository(WorkshopParticipant::class)->findOneBy(array (
            'workshop' => $workshop->getId(),
            'participant' => $participantId
        ));
        if ($workshopParticipant->getAttendingYn() == 'N') {
            $workshopParticipant->setAttendingYn('Y');
        }
        else {
            $workshopParticipant->setAttendingYn('N');
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($workshopParticipant);
        $entityManager->flush();

        return $this->redirectToRoute('workshop_manage_participants', array(
            'id' => $workshop->getId(),
            'backToRoute' => $backToRoute
        ));
    }

}

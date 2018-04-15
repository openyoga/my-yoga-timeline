<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Participant;
use App\Form\ParticipantType;

/**
 * @Route("/participants")
 */
class ParticipantController extends Controller
{
    /**
     * @Route("/", name="participants")
     * @Method({"GET"})
     */
    public function index()
    {
        $participants = $this->getDoctrine()->getRepository(Participant::class)->findBy(array(), array('firstName' => 'ASC', 'lastName' => 'ASC'));        
        return $this->render('participants/index.html.twig', array(
            'participants' => $participants
        ));
    }

    /**
     * @Route("/new", name="participant_new")
     * @Method({"GET", "POST"})
     */
    public function new(Request $request)
    {
        $participant = new Participant();
        $form = $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $participant = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($participant);
            $entityManager->flush();
            return $this->redirectToRoute('participants');
        }

        return $this->render('participants/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}/edit", requirements={"id": "\d+"}, name="participant_edit")
     * @Method({"GET", "POST"})
     */
    public function edit(Request $request, Participant $participant)
    {
        $form = $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $participant = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($participant);
            $entityManager->flush();
            //$this->addFlash('success', 'participant.updated_successfully');
            return $this->redirectToRoute('participants', array(
                'id' => $participant->getId()
            ));
        }

        return $this->render('participants/edit.html.twig', array(
            'participant' => $participant,
            'form' => $form->createView()
        ));
    }

}

<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Workshop;
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
            return $this->redirectToRoute($backToRoute, array(
                'id' => $workshop->getId()
            ));
        }

        return $this->render('workshops/edit.html.twig', array(
            'workshop' => $workshop,
            'form' => $form->createView(),
            'backToUrl' => $this->generateUrl($backToRoute)
        ));
    }

}

<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Inspiration;
use App\Form\InspirationType;

/**
 * @Route("/inspirations")
 */
class InspirationController extends Controller
{
    /**
     * @Route("/", name="inspirations")
     * @Method({"GET"})
     */
    public function index()
    {
        $inspirations = $this->getDoctrine()->getRepository(Inspiration::class)->findAll();        
        return $this->render('inspirations/index.html.twig', array(
            'inspirations' => $inspirations
        ));
    }

    /**
     * @Route("/new", name="inspiration_new")
     * @Method({"GET", "POST"})
     */
    public function new(Request $request)
    {
        $inspiration = new Inspiration();
        $form = $this->createForm(InspirationType::class, $inspiration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $inspiration = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($inspiration);
            $entityManager->flush();
            return $this->redirectToRoute('inspirations');
        }

        return $this->render('inspirations/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}/edit", requirements={"id": "\d+"}, name="inspiration_edit")
     * @Method({"GET", "POST"})
     */
    public function edit(Request $request, Inspiration $inspiration)
    {
        $form = $this->createForm(InspirationType::class, $inspiration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $inspiration = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($inspiration);
            $entityManager->flush();
            //$this->addFlash('success', 'inspiration.updated_successfully');
            return $this->redirectToRoute('inspirations', array(
                'id' => $inspiration->getId()
            ));
        }

        return $this->render('inspirations/edit.html.twig', array(
            'inspiration' => $inspiration,
            'form' => $form->createView()
        ));
    }

}

<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\EventCategory;
use App\Form\EventCategoryType;

/**
 * @Route("/event-categories")
 */
class EventCategoryController extends Controller
{
    /**
     * @Route("/", name="event_categories")
     * @Method({"GET"})
     */
    public function index()
    {
        $event_categories = $this->getDoctrine()->getRepository(EventCategory::class)->findBy(array(), array('name' => 'ASC'));         
        return $this->render('event_categories/index.html.twig', array(
            'event_categories' => $event_categories
        ));
    }

    /**
     * @Route("/new", name="event_category_new")
     * @Method({"GET", "POST"})
     */
    public function new(Request $request)
    {
        $event_category = new EventCategory();
        $form = $this->createForm(EventCategoryType::class, $event_category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event_category = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event_category);
            $entityManager->flush();
            return $this->redirectToRoute('event_categories');
        }

        return $this->render('event_categories/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}/edit", requirements={"id": "\d+"}, name="event_category_edit")
     * @Method({"GET", "POST"})
     */
    public function edit(Request $request, EventCategory $event_category)
    {
        $form = $this->createForm(EventCategoryType::class, $event_category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event_category = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event_category);
            $entityManager->flush();
            //$this->addFlash('success', 'event_category.updated_successfully');
            return $this->redirectToRoute('event_categories', array(
                'id' => $event_category->getId()
            ));
        }

        return $this->render('event_categories/edit.html.twig', array(
            'event_category' => $event_category,
            'form' => $form->createView()
        ));
    }

}

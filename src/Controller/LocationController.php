<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Location;
use App\Form\LocationType;

/**
 * @Route("/locations")
 */
class LocationController extends Controller
{
    /**
     * @Route("/", name="location_index")
     * @Method({"GET"})
     */
    public function index()
    {
        $locations = $this->getDoctrine()->getRepository(Location::class)->findAll();        
        return $this->render('locations/index.html.twig', array(
            'locations' => $locations
        ));
    }

    /**
     * @Route("/new", name="location_new")
     * @Method({"GET", "POST"})
     */
    public function new(Request $request)
    {
        $location = new Location();
        $form = $this->createForm(LocationType::class, $location);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $location = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($location);
            $entityManager->flush();
            return $this->redirectToRoute('location_index');
        }

        return $this->render('locations/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}/edit", requirements={"id": "\d+"}, name="location_edit")
     * @Method({"GET", "POST"})
     */
    public function edit(Request $request, Location $location)
    {
        $form = $this->createForm(LocationType::class, $location);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $location = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($location);
            $entityManager->flush();
            //$this->addFlash('success', 'location.updated_successfully');
            return $this->redirectToRoute('location_index', array(
                'id' => $location->getId()
            ));
        }

        return $this->render('locations/edit.html.twig', array(
            'location' => $location,
            'form' => $form->createView()
        ));
    }

}

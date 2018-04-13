<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\YogaStyle;
use App\Form\YogaStyleType;

/**
 * @Route("/yoga-styles")
 */
class YogaStyleController extends Controller
{
    /**
     * @Route("/", name="yoga_styles")
     * @Method({"GET"})
     */
    public function index()
    {
        $yoga_styles = $this->getDoctrine()->getRepository(YogaStyle::class)->findAll();        
        return $this->render('yoga_styles/index.html.twig', array(
            'yoga_styles' => $yoga_styles
        ));
    }

    /**
     * @Route("/new", name="yoga_style_new")
     * @Method({"GET", "POST"})
     */
    public function new(Request $request)
    {
        $yoga_style = new YogaStyle();
        $form = $this->createForm(YogaStyleType::class, $yoga_style);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $yoga_style = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($yoga_style);
            $entityManager->flush();
            return $this->redirectToRoute('yoga_styles');
        }

        return $this->render('yoga_styles/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}/edit", requirements={"id": "\d+"}, name="yoga_style_edit")
     * @Method({"GET", "POST"})
     */
    public function edit(Request $request, YogaStyle $yoga_style)
    {
        $form = $this->createForm(YogaStyleType::class, $yoga_style);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $yoga_style = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($yoga_style);
            $entityManager->flush();
            //$this->addFlash('success', 'yoga_style.updated_successfully');
            return $this->redirectToRoute('yoga_styles', array(
                'id' => $yoga_style->getId()
            ));
        }

        return $this->render('yoga_styles/edit.html.twig', array(
            'yoga_style' => $yoga_style,
            'form' => $form->createView()
        ));
    }

}

<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Workshop;

class HomeController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $workshops = $this->getDoctrine()->getRepository(Workshop::class)->findUpcomingJoinedDetails();
        return $this->render('index.html.twig', array(
            'workshops' => $workshops
        ));
    }
}
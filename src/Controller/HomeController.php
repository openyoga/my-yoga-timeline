<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Event;

class HomeController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $events = $this->getDoctrine()->getRepository(Event::class)->findUpcomingJoinedDetails();
        return $this->render('index.html.twig', array(
            'events' => $events
        ));
    }
}
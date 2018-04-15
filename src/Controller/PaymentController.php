<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Payment;
use App\Entity\PaymentParticipant;
use App\Entity\Participant;
use App\Form\PaymentType;

/**
 * @Route("/payments")
 */
class PaymentController extends Controller
{
    /**
     * @Route("/", name="payments")
     * @Method({"GET"})
     */
    public function index()
    {
        $payments = $this->getDoctrine()->getRepository(Payment::class)->findAllJoinedDetails();        
        return $this->render('payments/index.html.twig', array(
            'payments' => $payments
        ));
    }

    /**
     * @Route("/new", name="payment_new")
     * @Method({"GET", "POST"})
     */
    public function new(Request $request)
    {
        $payment = new Payment();
        $form = $this->createForm(PaymentType::class, $payment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $payment = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($payment);
            $entityManager->flush();
            return $this->redirectToRoute('payments');
        }

        return $this->render('payments/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}/edit/{backToRoute}", requirements={"id": "\d+"}, name="payment_edit")
     * @Method({"GET", "POST"})
     */
    public function edit(Request $request, Payment $payment, $backToRoute)
    {
        $form = $this->createForm(PaymentType::class, $payment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $payment = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($payment);
            $entityManager->flush();
            //$this->addFlash('success', 'payment.updated_successfully');
            return $this->redirectToRoute($backToRoute);
        }

        return $this->render('payments/edit.html.twig', array(
            'payment' => $payment,
            'form' => $form->createView(),
            'backToRoute' => $backToRoute,
            'backToUrl' => $this->generateUrl($backToRoute)
        ));
    }

    /**
     * @Route("/{id}/manage_participants/{backToRoute}", requirements={"id": "\d+"}, name="payment_manage_participants")
     * @Method({"GET"})
     */
    public function manage_participants(Request $request, Payment $payment, $backToRoute)
    {
        $paymentDetails = $this->getDoctrine()->getRepository(Payment::class)
            ->findOneByIdJoinedDetails($payment->getId());
        $participants = $this->getDoctrine()->getRepository(Payment::class)
            ->findParticipantsByPaymentId($payment->getId());
        $availableAarticipants = $this->getDoctrine()->getRepository(Payment::class)
            ->findAvailableParticipantsByPaymentId($payment->getId());
        return $this->render('payments/manage_participants.html.twig', array(
            'payment' => $paymentDetails,
            'participants' => $participants,
            'availableAarticipants' => $availableAarticipants,
            'backToRoute' => $backToRoute,
            'backToUrl' => $this->generateUrl($backToRoute)
        ));
    }

    /**
     * @Route("/{id}/add_participant/{participantId}/{backToRoute}", requirements={"id": "\d+", "participantId": "\d+"}, name="payment_add_participant")
     * @Method({"POST"})
     */
    public function add_participant(Request $request, Payment $payment, $participantId, $backToRoute)
    {
        $participant = $this->getDoctrine()->getRepository(Participant::class)->find($participantId);

        $paymentParticipant = new PaymentParticipant();
        $paymentParticipant->setPayment($payment);
        $paymentParticipant->setParticipant($participant);
        $paymentParticipant->setFeePayedYn('N');
        $paymentParticipant->setAttendingYn('Y');

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($paymentParticipant);
        $entityManager->flush();

        return $this->redirectToRoute('payment_manage_participants', array(
            'id' => $payment->getId(),
            'backToRoute' => $backToRoute
        ));
    }

    /**
     * @Route("/{id}/remove_participant/{participantId}/{backToRoute}", requirements={"id": "\d+", "participantId": "\d+"}, name="payment_remove_participant")
     * @Method({"POST"})
     */
    public function remove_participant(Request $request, Payment $payment, $participantId, $backToRoute)
    {
        $participant = $this->getDoctrine()->getRepository(Participant::class)->find($participantId);

        $paymentParticipant = $this->getDoctrine()->getRepository(PaymentParticipant::class)->findOneBy(array (
            'payment' => $payment->getId(),
            'participant' => $participantId
        ));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($paymentParticipant);
        $entityManager->flush();

        return $this->redirectToRoute('payment_manage_participants', array(
            'id' => $payment->getId(),
            'backToRoute' => $backToRoute
        ));
    }

    /**
     * @Route("/{id}/toggle_payed_status/{participantId}/{backToRoute}", requirements={"id": "\d+", "participantId": "\d+"}, name="toggle_payed_status")
     * @Method({"POST"})
     */
    public function toggle_payed_status(Request $request, Payment $payment, $participantId, $backToRoute)
    {
        $participant = $this->getDoctrine()->getRepository(Participant::class)->find($participantId);

        $paymentParticipant = $this->getDoctrine()->getRepository(PaymentParticipant::class)->findOneBy(array (
            'payment' => $payment->getId(),
            'participant' => $participantId
        ));
        if ($paymentParticipant->getFeePayedYn() == 'N') {
            $paymentParticipant->setFeePayedYn('Y');
        }
        else {
            $paymentParticipant->setFeePayedYn('N');
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($paymentParticipant);
        $entityManager->flush();

        return $this->redirectToRoute('payment_manage_participants', array(
            'id' => $payment->getId(),
            'backToRoute' => $backToRoute
        ));
    }

    /**
     * @Route("/{id}/toggle_attending_status/{participantId}/{backToRoute}", requirements={"id": "\d+", "participantId": "\d+"}, name="toggle_attending_status")
     * @Method({"POST"})
     */
    public function toggle_attending_status(Request $request, Payment $payment, $participantId, $backToRoute)
    {
        $participant = $this->getDoctrine()->getRepository(Participant::class)->find($participantId);

        $paymentParticipant = $this->getDoctrine()->getRepository(PaymentParticipant::class)->findOneBy(array (
            'payment' => $payment->getId(),
            'participant' => $participantId
        ));
        if ($paymentParticipant->getAttendingYn() == 'N') {
            $paymentParticipant->setAttendingYn('Y');
        }
        else {
            $paymentParticipant->setAttendingYn('N');
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($paymentParticipant);
        $entityManager->flush();

        return $this->redirectToRoute('payment_manage_participants', array(
            'id' => $payment->getId(),
            'backToRoute' => $backToRoute
        ));
    }

}

<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Expense;
use App\Form\ExpenseType;

/**
 * @Route("/expenses")
 */
class ExpenseController extends Controller
{
    /**
     * @Route("/", name="expenses")
     * @Method({"GET"})
     */
    public function index()
    {
        $expenses = $this->getDoctrine()->getRepository(Expense::class)->findAll();        
        return $this->render('expenses/index.html.twig', array(
            'expenses' => $expenses
        ));
    }

    /**
     * @Route("/new", name="expense_new")
     * @Method({"GET", "POST"})
     */
    public function new(Request $request)
    {
        $expense = new Expense();
        $form = $this->createForm(ExpenseType::class, $expense);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $expense = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($expense);
            $entityManager->flush();
            return $this->redirectToRoute('expenses');
        }

        return $this->render('expenses/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}/edit", requirements={"id": "\d+"}, name="expense_edit")
     * @Method({"GET", "POST"})
     */
    public function edit(Request $request, Expense $expense)
    {
        $form = $this->createForm(ExpenseType::class, $expense);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $expense = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($expense);
            $entityManager->flush();
            //$this->addFlash('success', 'expense.updated_successfully');
            return $this->redirectToRoute('expenses', array(
                'id' => $expense->getId()
            ));
        }

        return $this->render('expenses/edit.html.twig', array(
            'expense' => $expense,
            'form' => $form->createView()
        ));
    }

}

<?php

namespace App\Form;

use App\Entity\Payment;
use App\Entity\Participant;
use App\Repository\ParticipantRepository;
use App\Form\Type\DateTimePickerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PaymentType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Payment::class,
        ));
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // http://symfony.com/doc/current/reference/forms/types/choice.html#advanced-example-with-objects
            ->add('participant', EntityType::class, array(
                'class' => Participant::class,
                'required' => true,
                'choice_label' => function ($participant) {
                    return $participant->getFirstName() . ' ' . $participant->getLastName();},
                'query_builder' => function (ParticipantRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.firstName', 'ASC')
                        ->orderBy('p.lastName','ASC');}))
            ->add('receiptDate', DateTimePickerType::class, array(
                'required' => true,
                'format' => 'yyyy-MM-dd'))
            ->add('amount', MoneyType::class, array(
                'required' => true,
                'currency' => Payment::CURRENCY ))
            ->add('comment', TextareaType::class, array(
                'required' => false))
            ;
    }
}


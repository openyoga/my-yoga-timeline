<?php

namespace App\Form;

use App\Entity\Participant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ParticipantType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Participant::class,
        ));
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('academicTitle', TextType::class, array(
                'required' => false))
            ->add('firstName', TextType::class, array(
                'required' => true))
            ->add('lastName', TextType::class, array(
                'required' => false))
            ->add('email', EmailType::class, array(
                'required' => true))
            ->add('infoMailsYn', ChoiceType::class, array(
                'required' => true,
                'choices'  => array(
                    'Yes' => 'Y',
                    'No' => 'N'),
                'label' => 'Wants to have info mails (must be opt in!)'))
            ->add('activeYn', ChoiceType::class, array(
                'required' => true,
                'choices'  => array(
                    'Yes' => 'Y',
                    'No' => 'N'),
                'label' => 'Active'))
            ->add('comment', TextareaType::class, array(
                'required' => false))
            ;
    }
}


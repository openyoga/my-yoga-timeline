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
            ->add('academic_title', TextType::class, array(
                'required' => false))
            ->add('first_name', TextType::class, array(
                'required' => true))
            ->add('last_name', TextType::class, array(
                'required' => false))
            ->add('email', EmailType::class, array(
                'required' => true))
            ->add('comments', TextareaType::class, array(
                'required' => false))
            ->add('info_mails_yn', ChoiceType::class, array(
                'required' => true,
                'choices'  => array(
                    'Yes' => 'Y',
                    'No' => 'N'),
                'label' => 'Wants to have info mails (must be opt in!)'))
            ->add('active_yn', ChoiceType::class, array(
                'required' => true,
                'choices'  => array(
                    'Yes' => 'Y',
                    'No' => 'N'),
                'label' => 'Active'))
                        ;
    }
}


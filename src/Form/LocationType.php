<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class LocationType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Location::class,
        ));
    }
    
    // https://stackoverflow.com/questions/14756362/symfony2-form-validation-with-html5-and-cancel-button
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('street', TextType::class, array(
                //'label' => 'label.street',
                'required' => false
            ))
            ->add('zip_code', TextType::class, array(
                //'label' => 'label.zip_code',
                'required' => false
            ))
            ->add('city')
        ;
    }
}


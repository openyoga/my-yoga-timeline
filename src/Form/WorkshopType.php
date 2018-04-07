<?php

namespace App\Form;

use App\Entity\Workshop;
use App\Entity\YogaStyle;
use App\Entity\Location;
use App\Entity\Inspiration;
use App\Repository\InspirationRepository;
use App\Form\Type\DateTimePickerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class WorkshopType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Workshop::class,
        ));
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('yogaStyle', EntityType::class, array(
                'class' => YogaStyle::class,
                'choice_label' => 'name',
                'required' => true))
            ->add('location', EntityType::class, array(
                'class' => Location::class,
                'choice_label' => 'name',
                'required' => true))
            ->add('locationFee', MoneyType::class, array(
                'required' => true,
                'currency' => 'EUR'))
            // http://symfony.com/doc/current/reference/forms/types/choice.html#advanced-example-with-objects
            ->add('inspiration', EntityType::class, array(
                'class' => Inspiration::class,
                'required' => false,
                'choice_label' => function ($inspiration) {
                    return $inspiration->getAuthor() . ' - ' . $inspiration->getTitle();},
                'query_builder' => function (InspirationRepository $er) {
                    return $er->createQueryBuilder('i')
                        ->orderBy('i.author', 'ASC')
                        ->orderBy('i.title','ASC');}))
            ->add('plannedDate', DateTimePickerType::class, array(
                'required' => true,
                'format' => 'yyyy-MM-dd HH:mm'))
            ->add('duration', IntegerType::class, array(
                'required' => true,
                'label' => 'Duration in minutes'))
            ->add('fee', MoneyType::class, array(
                'required' => true,
                'currency' => 'EUR'))
            ->add('comments', TextareaType::class, array(
                'required' => false))
            ;
    }
}


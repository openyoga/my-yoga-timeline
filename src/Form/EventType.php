<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\EventCategory;
use App\Entity\Location;
use App\Entity\Inspiration;
use App\Repository\EventCategoryRepository;
use App\Repository\LocationRepository;
use App\Repository\InspirationRepository;
use App\Form\Type\DateTimePickerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class EventType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Event::class,
        ));
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', EntityType::class, array(
                'class' => EventCategory::class,
                'choice_label' => 'name',
                'required' => true,
                'query_builder' => function (EventCategoryRepository $r) {
                    return $r->createQueryBuilder('cr')
                        ->orderBy('cr.name', 'ASC');}))
            ->add('location', EntityType::class, array(
                'class' => Location::class,
                'choice_label' => 'name',
                'required' => true,
                'query_builder' => function (LocationRepository $r) {
                    return $r->createQueryBuilder('l')
                        ->orderBy('l.name', 'ASC');}))
            ->add('locationFee', MoneyType::class, array(
                'required' => true,
                'currency' => 'EUR'))
            // http://symfony.com/doc/current/reference/forms/types/choice.html#advanced-example-with-objects
            ->add('inspiration', EntityType::class, array(
                'class' => Inspiration::class,
                'required' => false,
                'choice_label' => function ($inspiration) {
                    return $inspiration->getAuthor() . ' - ' . $inspiration->getTitle();},
                'query_builder' => function (InspirationRepository $r) {
                    return $r->createQueryBuilder('i')
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
            ->add('comment', TextareaType::class, array(
                'required' => false))
            ;
    }
}


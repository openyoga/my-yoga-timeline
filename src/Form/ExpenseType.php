<?php

namespace App\Form;

use App\Entity\Expense;
use App\Form\Type\DateTimePickerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class ExpenseType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Expense::class,
        ));
    }
    
    // https://stackoverflow.com/questions/14756362/symfony2-form-validation-with-html5-and-cancel-button
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateSpent', DateTimePickerType::class, array(
                'required' => true,
                'format' => 'yyyy-MM-dd'))
            ->add('amount', MoneyType::class, array(
                'required' => true,
                'currency' => 'EUR'))
            ->add('description', TextareaType::class, array(
                'required' => true))
        ;
    }
}


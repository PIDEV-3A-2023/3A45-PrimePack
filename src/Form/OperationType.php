<?php

namespace App\Form;

use App\Entity\Operation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use App\Form\Transformer;

class OperationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_operation', DateTimeType::class, [
                
                'label' => 'Date et heure',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('type_operation', ChoiceType::class,[ 'choices' => [
                'Surgury' => 'Surgury',
                'Vaccination' => 'Vaccination',
                'Operation' => 'Operation',
                'Autre' => 'Autre'
            ],
            'attr' => [
                'class' => 'form-control mb-3',
            ],])
            ->add('nom_medecin',TextType::class,[ 'attr' => [
                'class' => 'form-control mb-3',
            ],])
            ->add('cout_operation', IntegerType::class, [
                'label' => 'Coût de l\'opération',
                'attr' => [
                    'min' => 0,
                    'step' => 1,
                ],
            ])
            ->add('note_operation',TextareaType::class,[ 'attr' => [
                'class' => 'form-control mb-3',
            ],])
            ->add('maladie')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Operation::class,
        ]);
    }
}

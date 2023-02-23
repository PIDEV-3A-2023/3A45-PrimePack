<?php

namespace App\Form;

use App\Entity\Maladie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Form\Transformer;

class MaladieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,[ 'attr' => [
                'class' => 'form-control mb-3',
            ],])
            ->add('description',TextareaType::class,[ 'attr' => [
                'class' => 'form-control mb-3',
            ],])
            ->add('type_aniaml', ChoiceType::class,[ 'choices' => [
                'Chien' => 'chien',
                'Chat' => 'chat',
                'Oiseau' => 'oiseau',
                'Autre' => 'autre'
            ],
            'attr' => [
                'class' => 'form-control mb-3',
            ],])
            ->add('date_creation', DateTimeType::class, [
                
                'label' => 'Date et heure',
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'yyyy-MM-dd HH:mm:ss',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('date_MAJ', DateTimeType::class, [
                
                'label' => 'Date et heure',
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'yyyy-MM-dd HH:mm:ss',
                'attr' => [
                    'class' => 'form-control',
                ],
            ]);
            
            
            
            
            
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Maladie::class,
        ]);
    }
}

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
            ->add('type_aniaml', TextType::class,[ 'attr' => [
                'class' => 'form-control mb-3',
            ],])
            ->add('date_creation', DateType::class, [
                
                'label' => 'Date et heure de creation',
                'widget' => 'single_text',

        
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('date_MAJ', DateType::class, [
                
                'label' => 'Date et heure de mise a jour',
                'widget' => 'single_text',
                
                
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

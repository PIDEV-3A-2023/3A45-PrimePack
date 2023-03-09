<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
             ->add('Nom' , null, array(
                    'attr' => array(
                'placeholder' => 'Entrez votre nom',
            ))
    )
            ->add('Prenom' , null, array(
                'attr' => array(
                    'placeholder' => 'Entrez votre prenom',
                ))
        )
            ->add('Email' , null, array(
            'attr' => array(
                'placeholder' => 'Entrez votre adresse mail',
            )))
            ->add('Password', PasswordType::class, array(
            'attr' => array(
                'placeholder' => 'Entrez votre mot passe', 'label' => 'Password'
            )))
            ->add('DateN')
            ->add('Numero', null, array(
                'attr' => array(
                    'placeholder' => 'Entrez votre numero',
                ))
        )
            ->add('Adresse', null, array(
                'attr' => array(
                    'placeholder' => 'Entrez votre adresse',
                ))
        )
            ->add('role', ChoiceType::class,[
            'required'=> true,
            'multiple'=> false,
            'expanded'=> false,
            'choices'=> [
                'Patient'=> 'ROLE_USER',
                'Veterinaire'=> 'ROLE_USER',
                'Admin'=> 'ROLE_ADMIN',
            ],
        ])
            ->add('save', SubmitType::Class)

        /* ->add('produit')
         ->add('evenement')
         ->add('rendezvous')*/
    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

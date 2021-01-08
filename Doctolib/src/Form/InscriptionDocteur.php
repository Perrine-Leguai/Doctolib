<?php

namespace App\Form;


use App\Entity\Docteur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class InscriptionDocteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('password', PasswordType::class)
            ->add('confirmPassword', PasswordType::class)
            ->add('numeroOrdre')
            ->add('nom')
            ->add('prenom')
            ->add('adresseTravail')
            ->add('codePostal')
            ->add('ville')
            ->add('email')
            ->add('telephone')
            ->add('lienSiteInternet')
            ->add('specialites')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Docteur::class,
        ]);
    }
}

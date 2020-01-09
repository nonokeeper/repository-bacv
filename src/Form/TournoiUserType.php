<?php

namespace App\Form;

use App\Entity\TournoiUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TournoiUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('inscription')
            ->add('participation')
            ->add('resultatSimple')
            ->add('resultatDouble')
            ->add('resultatMixte')
            ->add('nbTableaux')
            ->add('inscriptionSimple')
            ->add('inscriptionDouble')
            ->add('inscriptionMixte')
            ->add('participationSimple')
            ->add('participationDouble')
            ->add('participationMixte')
            ->add('tournoi')
            ->add('user')
            ->add('partenaireDouble')
            ->add('partenaireMixte')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TournoiUser::class,
        ]);
    }
}

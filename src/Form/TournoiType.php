<?php

namespace App\Form;

use App\Entity\Tournoi;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class TournoiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('date_debut')
            ->add('date_fin')
            ->add('lieu')
            ->add('lien_inscription')
            ->add('classements')
            ->add('categories')
            ->add('tableaux')
            ->add('date_inscription')
            ->add('lien_description')
            ->add('club')
            ->add('saison')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tournoi::class,
        ]);
    }
}

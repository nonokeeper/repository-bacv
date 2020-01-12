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
            ->add('date_debut', DateType::class, [
                'format' => 'd/MMM/y',
                ])
            ->add('date_fin', DateType::class, [
                'format' => 'd/MMM/y',
                ])
            ->add('lieu')
            ->add('lien_inscription')
            ->add('classements')
            ->add('categories')
            ->add('tableaux')
            ->add('date_inscription', DateType::class,[
                'label' => 'Date limite d\'inscription',
                'format' => 'd/MMM/y',
            ])
            ->add('lien_description')
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

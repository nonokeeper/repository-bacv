<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('beginAt')
            ->add('endAt')
            ->add('titre')
            ->add('description')
            ->add('category', ChoiceType::class, [
                'placeholder' => '-- Choisir la catégorie --',
                'choices' => [
                    'Tournoi' => 'Tournoi',
                    'Interclub' => 'Interclub',
                    'Stand LardeSports' => 'Stand LardeSports',
                    'Assemblée Générale' => 'Assemblée Générale',
                    'Fermeture Gymnases' => 'Fermeture Gymnases',
                    'Fête du Club' => 'Fête du Club',
                    'Autre' => 'Autre'
                ],
                'label' => 'Lieu',
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Team;
use App\Entity\Saison;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('email', EmailType::class, [
                'required' => true,
                'invalid_message' => 'toto'
            ])
            ->add('firstName', null, [
                'attr' => ['minLength' => 2,'maxlength' => 50],
                'required' => true
            ])
            ->add('lastName', null, [
                'attr' => ['minLength' => 2,'maxlength' => 100]
            ])
            ->add('mobile', null, [
                'attr' => ['maxlength' => 10]
            ])
            ->add('birthDate', BirthdayType::class, [
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ],
                'widget' => 'choice',
                'format' => 'dd/MM/yyyy',
            ])
            ->add('license')
            ->add('classement_simple')
            ->add('classement_double')
            ->add('classement_mixte')
            ->add('rue')
            ->add('code_postal')
            ->add('ville')
            ->add('team', EntityType::class, [
                'class' => Team::class,
                'choice_label' => 'name'
            ])
            ->add('teamVeteran', EntityType::class, [
                'class' => Team::class,
                'choice_label' => 'name'
            ])
            ->add('saison', EntityType::class, [
                'class' => Saison::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

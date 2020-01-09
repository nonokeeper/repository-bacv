<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\AgeCategory;
use App\Entity\Team;
use App\Entity\TeamVeteran;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class UserCompteFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', EmailType::class, [
            'required' => true,
        ])
        ->add('firstName', null, [
            'attr' => ['minLength' => 2,'maxlength' => 50],
            'required' => true
        ])
        ->add('lastName', null, [
            'attr' => ['minLength' => 2,'maxlength' => 100],
            'required' => true
        ])
        ->add('mobile', null, [
            'attr' => ['maxlength' => 14]
        ])
        ->add('mobile_parent', null, [
            'attr' => ['maxlength' => 14]
        ])
        ->add('birthDate', BirthdayType::class, [
            'required' => false,
            'placeholder' => [
                'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
            ],
            'widget' => 'choice',
            'format' => 'dd/MM/yyyy',
        ])
        ->add('ageCategory', EntityType::class, [
            'class' => AgeCategory::class,
            'label' => 'Catégorie d\'âge',
            'disabled' => true
        ])
        ->add('team', EntityType::class, [
            'class' => Team::class,
            'placeholder' => '-- Aucune --',
            'required' => false,
            'label' => 'Equipe Interclub',
            'disabled' => true
        ])
        ->add('teamVeteran', EntityType::class, [
            'class' => TeamVeteran::class,
            'placeholder' => '-- Aucune --',
            'label' => 'Equipe Vétéran Interclub',
            'required' => false,
            'disabled' => true
        ])
        ->add('gender', ChoiceType::class, [
            'choices'  => [
                'Homme / Garçon' => 'H',
                'Femme / Fille' => 'F',
            ],
        ])
        ->add('license')
        ->add('classement_simple')
        ->add('classement_double')
        ->add('classement_mixte')
        ->add('rue', TextareaType::class, [
            'required' => false
        ])
        ->add('code_postal')
        ->add('ville')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

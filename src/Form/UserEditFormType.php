<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Team;
use App\Entity\TeamVeteran;
use App\Entity\AgeCategory;
use App\Repository\TeamRepository;
use App\Repository\TeamVeteranRepository;
use App\Repository\ClubRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\CallbackTransformer;
use Doctrine\Common\Persistence\ManagerRegistry;

class UserEditFormType extends AbstractType
{
    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
        $this->club = 0;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $repositoryClub = new ClubRepository($this->registry);
        $this->club = $repositoryClub->findClubBySlug('BACV');

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
            ->add('category', ChoiceType::class, [
                'choices'  => [
                    '-- Aucun --' => 'Aucun',
                    'Jeune' => 'Jeune',
                    'Loisir' => 'Loisir',
                    'Loisir avec Interclub' => 'Loisir avec Interclub',
                    'Compétiteur' => 'Compétiteur',
                ],
                'label' => 'Groupe :'
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
            ->add('username')
            ->add('roles', ChoiceType::class, [
                'choices'  => [
                    'Joueur Simple' => 'ROLE_USER',
                    'Bureau ou Capitaine' => 'ROLE_ADMIN',
                //    'Administrateur' => 'ROLE_SUPER_ADMIN',
                ],
            ])
            ->add('active', CheckboxType::class, [
                'required' => false
            ])
            ->add('rue', TextareaType::class, [
                'required' => false
            ])
            ->add('code_postal')
            ->add('ville')
            ->add('ageCategory', EntityType::class, [
                'class' => AgeCategory::class,
                'label' => 'Catégorie d\'âge',
                'disabled' => true
            ])
            ->add('team', EntityType::class, [
                'class' => Team::class,
                'placeholder' => '-- Aucune --',
                'required' => false,
                'query_builder' => function (TeamRepository $tr) {
                    return $tr->createQueryBuilder('t')
                        ->andWhere('t.club = :var')
                        ->setParameter('var', $this->club);
                },
                'label' => 'Equipe Interclub :',
                'choice_label' => 'name',
                'choice_value' => 'id',
                'empty_data' => null
            ])
            ->add('teamVeteran', EntityType::class, [
                'class' => TeamVeteran::class,
                'placeholder' => '-- Aucune --',
                'required' => false,
                'query_builder' => function (TeamVeteranRepository $tvr) {
                    return $tvr->createQueryBuilder('t')
                        ->andWhere('t.club = :var')
                        ->setParameter('var', $this->club);
                },
                'label' => 'Equipe Vétéran Interclub :',
                'choice_label' => 'name',
                'choice_value' => 'id',
                'empty_data' => null
            ])
        ;
        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($tagsAsArray) {
                    // transform the array to a string
                    //return implode(', ', $tagsAsArray);
                    return $tagsAsArray[0];
                },
                function ($tagsAsString) {
                    // transform the string back to an array
                    //return explode(', ', $tagsAsString);
                    return array($tagsAsString);
                }
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

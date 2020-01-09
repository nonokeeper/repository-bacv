<?php

namespace App\Form;

use App\Entity\Interclub;
use App\Entity\Team;
use App\Entity\User;
use App\Entity\Club;
use App\Entity\Saison;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use App\Repository\UserRepository;
use App\Repository\ClubRepository;

class InterclubNewMasculinType extends AbstractType
{
    private $em;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        $this->registry = $registry;
        $this->club = 0;
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $repositoryClub = new ClubRepository($this->registry);
        $this->club = $repositoryClub->findClubBySlug('BACV');
        $builder
            ->add('name')
            ->add('dateRencontre', DateTimeType::class, [
                'format' => 'dd/mm/yyyy',
                'data'  =>  new \DateTime("now + 1 month")
                ])
            ->add('score')
            ->add('saison', EntityType::class, [
                'class' => Saison::class,
                'label' => 'Saison',
                'required' => false,
                'placeholder' => '-- Aucune --',
                'data'  => $this->em->getReference(Saison::class, $_ENV['SAISON'])
            ])
            ->add('teamhome', EntityType::class, [
                'class' => Team::class,
                'placeholder' => '-- Aucune --',
                'required' => false,
                'label' => 'Equipe Domicile :',
                'choice_label' => 'name',
                'choice_value' => 'id',
                'empty_data' => null
            ])
            ->add('teamext', EntityType::class, [
                'class' => Team::class,
                'placeholder' => '-- Aucune --',
                'required' => false,
                'label' => 'Equipe Extérieur :',
                'choice_label' => 'name',
                'choice_value' => 'id',
                'empty_data' => null
            ])
            ->add('location', ChoiceType::class, [
                'placeholder' => '-- Choisir le lieu --',
                'choices' => [
                    'Equipe domicile à sélectionner' => null
                ],
                'label' => 'Lieu',
                'required' => false,
            ])
            ->add('SH1', EntityType::class, [
                'placeholder' => '-- Non défini --',
                'class'     => User::class,
                'query_builder' => function (UserRepository $ur) {
                    return $ur->createQueryBuilder('u')
                        ->andWhere('u.club = :club')
                        ->setParameter('club', $this->club)
                        ->andWhere('u.active = :active')
                        ->setParameter('active', 1)
                        ->andWhere('u.gender = :gender')
                        ->setParameter('gender', 'H')
                        ->andWhere('u.category = :groupe')
                        ->setParameter('groupe', 'Loisir avec Interclub');
                },
                'label'     => 'Simple Homme 1',
                'choice_label' => 'fullName',
                'required' => false,
                'empty_data' => null
            ])
            ->add('SH2', EntityType::class, [
                'placeholder' => '-- Non défini --',
                'class'     => User::class,
                'query_builder' => function (UserRepository $ur) {
                    return $ur->createQueryBuilder('u')
                        ->andWhere('u.club = :club')
                        ->setParameter('club', $this->club)
                        ->andWhere('u.active = :active')
                        ->setParameter('active', 1)
                        ->andWhere('u.gender = :gender')
                        ->setParameter('gender', 'H')
                        ->andWhere('u.category = :groupe')
                        ->setParameter('groupe', 'Loisir avec Interclub');
                },
                'label'     => 'Simple Homme 2',
                'choice_label' => 'fullName',
                'required' => false,
                'empty_data' => null
            ])
            ->add('SH3', EntityType::class, [
                'placeholder' => '-- Non défini --',
                'class'     => User::class,
                'query_builder' => function (UserRepository $ur) {
                    return $ur->createQueryBuilder('u')
                        ->andWhere('u.club = :club')
                        ->setParameter('club', $this->club)
                        ->andWhere('u.active = :active')
                        ->setParameter('active', 1)
                        ->andWhere('u.gender = :gender')
                        ->setParameter('gender', 'H')
                        ->andWhere('u.category = :groupe')
                        ->setParameter('groupe', 'Loisir avec Interclub');
                },
                'label'     => 'Simple Homme 3',
                'choice_label' => 'fullName',
                'required' => false,
                'empty_data' => null
            ])
            ->add('SH4', EntityType::class, [
                'placeholder' => '-- Non défini --',
                'class'     => User::class,
                'query_builder' => function (UserRepository $ur) {
                    return $ur->createQueryBuilder('u')
                        ->andWhere('u.club = :club')
                        ->setParameter('club', $this->club)
                        ->andWhere('u.active = :active')
                        ->setParameter('active', 1)
                        ->andWhere('u.gender = :gender')
                        ->setParameter('gender', 'H')
                        ->andWhere('u.category = :groupe')
                        ->setParameter('groupe', 'Loisir avec Interclub');
                },
                'label'     => 'Simple Homme 4',
                'choice_label' => 'fullName',
                'required' => false,
                'empty_data' => null
            ])
            ->add('DH1Joueur1', EntityType::class, [
                'placeholder' => '-- Non défini --',
                'class'     => User::class,
                'query_builder' => function (UserRepository $ur) {
                    return $ur->createQueryBuilder('u')
                        ->andWhere('u.club = :club')
                        ->setParameter('club', $this->club)
                        ->andWhere('u.active = :active')
                        ->setParameter('active', 1)
                        ->andWhere('u.gender = :gender')
                        ->setParameter('gender', 'H')
                        ->andWhere('u.category = :groupe')
                        ->setParameter('groupe', 'Loisir avec Interclub');
                },
                'label'     => 'Double Homme 1 Joueur 1',
                'choice_label' => 'fullName',
                'required' => false,
                'empty_data' => null
            ])
            ->add('DH1Joueur2', EntityType::class, [
                'placeholder' => '-- Non défini --',
                'class'     => User::class,
                'query_builder' => function (UserRepository $ur) {
                    return $ur->createQueryBuilder('u')
                        ->andWhere('u.club = :club')
                        ->setParameter('club', $this->club)
                        ->andWhere('u.active = :active')
                        ->setParameter('active', 1)
                        ->andWhere('u.gender = :gender')
                        ->setParameter('gender', 'H')
                        ->andWhere('u.category = :groupe')
                        ->setParameter('groupe', 'Loisir avec Interclub');
                },
                'label'     => 'Double Homme 1 Joueur 2',
                'choice_label' => 'fullName',
                'required' => false,
                'empty_data' => null
            ])
            ->add('DH2Joueur1', EntityType::class, [
                'placeholder' => '-- Non défini --',
                'class'     => User::class,
                'query_builder' => function (UserRepository $ur) {
                    return $ur->createQueryBuilder('u')
                        ->andWhere('u.club = :club')
                        ->setParameter('club', $this->club)
                        ->andWhere('u.active = :active')
                        ->setParameter('active', 1)
                        ->andWhere('u.gender = :gender')
                        ->setParameter('gender', 'H')
                        ->andWhere('u.category = :groupe')
                        ->setParameter('groupe', 'Loisir avec Interclub');
                },
                'label'     => 'Double Homme 2 Joueur 1',
                'choice_label' => 'fullName',
                'required' => false,
                'empty_data' => null
            ])
            ->add('DH2Joueur2', EntityType::class, [
                'placeholder' => '-- Non défini --',
                'class'     => User::class,
                'query_builder' => function (UserRepository $ur) {
                    return $ur->createQueryBuilder('u')
                        ->andWhere('u.club = :club')
                        ->setParameter('club', $this->club)
                        ->andWhere('u.active = :active')
                        ->setParameter('active', 1)
                        ->andWhere('u.gender = :gender')
                        ->setParameter('gender', 'H')
                        ->andWhere('u.category = :groupe')
                        ->setParameter('groupe', 'Loisir avec Interclub');
                },
                'label'     => 'Double Homme 2 Joueur 2',
                'choice_label' => 'fullName',
                'required' => false,
                'empty_data' => null
            ])
        ;

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                /** @var Interclub|null $data */
                $data = $event->getData();
                if (!$data) {
                    return;
                }
                $this->setupLocation(
                    $event->getForm(),
                    $data->getTeamHome()
                );
            }
        );

        /** @var Interclub|null $interclub */
        $interclub = $options['data'] ?? null;
        /** @var Team|null $teamhome */
        $teamhome = $interclub ? $interclub->getTeamHome() : null;

        if ($teamhome) {
            $choices = $this->getLocation($teamhome);
            if (!$choices) {
                $choices = array('Définir un lieu pour ce club !' => null);
            }
            $builder->add('location', ChoiceType::class, [
                'placeholder' => '-- Choisir le lieu (fin du Builder) --',
                'choices' => $choices,
                'label' => 'Lieu',
                'required' => false,
            ]);
        }

        $builder->get('teamhome')->addEventListener(
            FormEvents::POST_SUBMIT,
            function(FormEvent $event) {
                $form = $event->getForm();
                $this->setupLocation(
                    $form->getParent(),
                    $form->getData()
                );
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Interclub::class,
        ]);
    }

    private function getLocation(Team $team)
    {
        // 1. Récupération du club de cette équipe
        $club = $team->getClub();

        if ($club) {
            $lieux = $club->getLieux();
        }
        $idLieux = array();
        $nameLieux = array();
        $i=0;
        foreach($lieux as $lieu)
        {
            $id = $lieu->getId();
            $name = $lieu->getName();
            $idLieux[$i] = $id;
            $nameLieux[$i] = $name;
            $i++;
        }
        if ($i == 0) {
            return null;
        }
        return array_combine($nameLieux, $idLieux);

    }

    private function setupLocation(FormInterface $form, ?Team $team)
    {
        if (null === $team) {
            $form->remove('location');
            return;
        }

        $choices = $this->getLocation($team);
        if (null === $choices) {
            $form->remove('location');
            return;
        }

        $form->add('location', ChoiceType::class, [
            'placeholder' => '-- Choisir le lieu --',
            'choices' => $choices,
            'label' => 'Lieu',
            'required' => false,
        ]);
    }
}

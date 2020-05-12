<?php

namespace App\Form;

use App\Entity\Interclub;
use App\Entity\Team;
use App\Entity\User;
use App\Entity\Club;
use App\Entity\Saison;
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
use App\Repository\TeamRepository;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class InterclubMasculinType extends AbstractType
{
    /**
     * @var Int
     */
    private $saison;

    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
        $this->club = 0;
        $this->saison = $_ENV['SAISON'];
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $repositoryClub = new ClubRepository($this->registry);
        $this->club = $repositoryClub->findClubBySlug('BACV');
        $builder
            ->add('name')
            ->add('dateRencontre', DateTimeType::class, [
                'format' => 'dd/mm/yyyy'
                ])
            ->add('score')
            ->add('saison', EntityType::class, [
                'class' => Saison::class,
                'label' => 'Saison',
                'required' => false,
                'placeholder' => '-- Aucune --'
            ])
            ->add('teamhome', EntityType::class, [
                'class' => Team::class,
                'placeholder' => '-- Aucune --',
                'query_builder' => function (TeamRepository $tr) {
                    return $tr->createQueryBuilder('t')
                        ->andWhere('t.mixte = :mixte')
                        ->setParameter('mixte', 0)
                        ->orderBy('t.name', 'ASC');
                },
                'required' => false,
                'label' => 'Equipe Domicile',
                'choice_label' => 'name',
                'choice_value' => 'id',
                'empty_data' => null
            ])
            ->add('teamext', EntityType::class, [
                'class' => Team::class,
                'placeholder' => '-- Aucune --',
                'query_builder' => function (TeamRepository $tr) {
                    return $tr->createQueryBuilder('t')
                        ->andWhere('t.mixte = :mixte')
                        ->setParameter('mixte', 0)
                        ->orderBy('t.name', 'ASC');
                },
                'required' => false,
                'label' => 'Equipe Extérieur',
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
            ->add('save', SubmitType::class, ['label' => 'Sauvegarder'])
            ->add('saveAndQuit', SubmitType::class, ['label' => 'Sauvegarder et Quitter'])
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

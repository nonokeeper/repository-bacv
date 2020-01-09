<?php

namespace App\Form;

use App\Entity\InterclubVeteran;
use App\Entity\TeamVeteran;
use App\Entity\Club;
use App\Entity\Saison;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

class InterclubVeteranType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('dateRencontre', DateTimeType::class, [
                'format' => 'dd/mm/yyyy',
                ])
            ->add('score')
            ->add('saison', EntityType::class, [
                'class' => Saison::class,
                'label' => 'Saison',
                'required' => false,
                'placeholder' => '-- Aucune --'
            ])
            ->add('teamhome', EntityType::class, [
                'class' => TeamVeteran::class,
                'placeholder' => '-- Aucune --',
                'required' => false,
                'label' => 'Equipe Domicile :',
                'choice_label' => 'name',
                'choice_value' => 'id',
                'empty_data' => null
            ])
            ->add('teamext', EntityType::class, [
                'class' => TeamVeteran::class,
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
        ;

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                /** @var InterclubVeteran|null $data */
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

        /** @var InterclubVeteran|null $interclubVeteran */
        $interclubVeteran = $options['data'] ?? null;
        /** @var TeamVeteran|null $teamhome */
        $teamhome = $interclubVeteran ? $interclubVeteran->getTeamHome() : null;

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
            'data_class' => InterclubVeteran::class,
        ]);
    }

    private function getLocation(TeamVeteran $team)
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

    private function setupLocation(FormInterface $form, ?TeamVeteran $team)
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

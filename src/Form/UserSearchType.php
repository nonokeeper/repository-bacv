<?php

namespace App\Form;

use App\Entity\UserSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Team;
use App\Entity\Saison;
use App\Repository\TeamRepository;
use App\Repository\ClubRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\SearchType;

class UserSearchType extends AbstractType
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

        $builder
        ->add('team', EntityType::class, [
            'class' => Team::class,
            'placeholder' => '-- Equipe Interclub --',
            'required' => false,
            'query_builder' => function (TeamRepository $ur) {
                return $ur->createQueryBuilder('t')
                    ->andWhere('t.club = :var')
                    ->setParameter('var', $this->club);
            },
            'label' => false,
            'choice_label' => 'name',
            'choice_value' => 'id',
            'empty_data' => null
        ])
        ->add('category', ChoiceType::class, [
            'placeholder' => '-- Groupe --',
            'required' => false,
            'choices'  => [
                'Aucun' => 'Aucun',
                'Jeune' => 'Jeune',
                'Loisir' => 'Loisir',
                'Loisir avec Interclub' => 'Loisir avec Interclub',
                'Compétiteur' => 'Compétiteur',
            ],
            'label' => false
        ])
        ->add('libre', SearchType::class,[
            'label'     =>  false,
            'required'  =>  false,
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'    => UserSearch::class,
            'method'        => 'get',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix() {
        return '';
    }
}

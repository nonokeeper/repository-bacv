<?php

namespace App\Form;

use App\Entity\TeamVeteran;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\ClubRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\Common\Persistence\ManagerRegistry;

class TeamVeteranType extends AbstractType
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
        ->add('name')
        ->add('slug')
        ->add('users', EntityType::class, [
            'class'     => User::class,
            'query_builder' => function (UserRepository $ur) {
                return $ur->createQueryBuilder('u')
                    ->andWhere('u.club = :club')
                    ->setParameter('club', $this->club)
                    ->andWhere('u.active = :active')
                    ->setParameter('active', 1)
                    ->andWhere('u.category = :groupe')
                    ->setParameter('groupe', 'Compétiteur');
            },
            'label'     => 'Joueurs',
            'choice_label' => 'nameWithTeamVeteran',
            'expanded'  => true,
            'multiple'  => true,
            'by_reference' => false
        ])
        ->add('club')
        ->add('saison')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TeamVeteran::class,
        ]);
    }
}

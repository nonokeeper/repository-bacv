<?php

namespace App\Form;

use App\Entity\Actualite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class ActualiteNewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('content')
            ->add('startDate', DateTimeType::class, [
                'format' => 'dd/mm/yyyy',
                'data'  =>  new \DateTime("now")
                ])
            ->add('endDate', DateTimeType::class, [
                'format' => 'dd/mm/yyyy',
                'data'  =>  new \DateTime("now + 1 day")
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Actualite::class,
        ]);
    }
}

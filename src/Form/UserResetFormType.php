<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserResetFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('userName', null, [
                'attr' => ['minLength' => 2,'maxlength' => 50],
                'required' => true
            ])
            ->add('firstName', null, [
                'attr' => ['minLength' => 2,'maxlength' => 100]
            ])
            ->add('lastName', null, [
                'attr' => ['minLength' => 2,'maxlength' => 100]
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

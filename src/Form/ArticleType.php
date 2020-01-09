<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('picture',null, [
                'label' => 'Image'
            ])
            ->add('title',null, [
                'label' => 'Titre'
            ])
        //    ->add('auteur')
        //    ->add('slug')
            ->add('content', CKEditorType::Class, [
                'label' => 'Contenu de l\'article'
            ])
            ->add('excerpt', null, [
                'label' => 'Extrait'
            ])
            ->add('isPublished',null, [
                'label' => 'Publié'
            ])
            ->add('categories')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}

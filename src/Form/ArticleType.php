<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',null, [
                'label' => 'Titre',
                'required' => true
            ])
        //    ->add('auteur')
        //    ->add('slug')
            ->add('Image', FileType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '4096k',
                        'mimeTypes' => [
                            'image/jpg',
                            'image/png',
                            'image/jpeg',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => 'Merci de sélectionner une image valide',
                    ])
                ],
            ])
            ->add('Image2', FileType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '4096k',
                        'mimeTypes' => [
                            'image/jpg',
                            'image/png',
                            'image/jpeg',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => 'Merci de sélectionner une image valide',
                    ])
                ],
            ])
            ->add('content', CKEditorType::class, [
                'label' => 'Contenu de l\'article',
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

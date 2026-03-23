<?php

namespace App\Form;

use App\Entity\Movie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', options: [
                'label'=> 'Titre du film',
            ])
            ->add('overview')
            ->add('releaseDate', options: [
                'label'=> 'Date de sortie',
            ])
            ->add('posterPath', options: [
                'label'=> 'Lien du poster',
                'attr' => [
                    'placeholder'=> $_ENV['TMDB_URL_IMAGE_PREFIX'],
                ],
            ])
            ->add('idIMDB', options: [
                'label'=> 'Id chez imdb',
            ])
            ->add('runtime', options: [
                'label'=> 'Durée du film',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
        ]);
    }
}

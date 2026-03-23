<?php

namespace App\Form;

use App\Entity\Movie;
use App\Entity\MovieLover;
use App\Entity\Rating;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Date;

class RatingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('rating', RangeType::class, [
            'label'=> 'note de 1 à 5 étoiles',
                'attr' => [
                    'min' => 1,
                    'max' => 5,
                    'step' => 1,
                ],
                ]
            )
            ->add('createdAt', null, [
                'widget' => 'single_text',
                'data' => new \DateTimeImmutable()
            ])
            ->add('updatedAt', options: [
                'data' => new \DateTime()
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rating::class,
        ]);
    }
}

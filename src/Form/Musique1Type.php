<?php

namespace App\Form;

use App\Entity\Musique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;


class Musique1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('genre')
            ->add('artiste')
            ->add('musicpath',FileType::class,[
                'label' => '8neya',
                "mapped" => false,
                'required' => false,
            ])
            ->add('image',FileType::class,[
                'label' => 'taswira',
                "mapped" => false,
                'required' => false,
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Musique::class,
        ]);
    }
}

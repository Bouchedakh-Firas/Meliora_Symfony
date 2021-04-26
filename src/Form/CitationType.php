<?php

namespace App\Form;

use App\Entity\Citations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CitationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('auteur',TextType::class, [
                'label'=>'Nom du l auteur : ',
                'attr'=>[
                    'placeholder'=>'merci de saisir le de l auteur ',
                    'class'=>'name'
                ]
            ])
            ->add('text',TextareaType::class,[
                'label'=>'Contenu : ',
                'attr'=>[
                    'placeholder'=>'Example Txt....',
                    'class'=>'auteur'
                ]
            ])
            ->add('genre',TextType::class,[
                'label'=>'Genre : ',
                'attr'=>[
                    'placeholder'=>'Example Txt....',
                    'class'=>'genre'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Citations::class,
        ]);
    }
}

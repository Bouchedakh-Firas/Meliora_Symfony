<?php

namespace App\Form;

use App\Entity\EBooks;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class EbookType extends AbstractType
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
            ->add('genre',TextType::class, [
                'label'=>'Genre : ',
                'attr'=>[
                    'placeholder'=>'merci de saisir le genre du livre ',
                    'class'=>'genre'
                ]
            ])
            ->add('favoris',IntegerType::class,[
                'label'=>'Favoris : ',
                'attr'=>[
                    'placeholder'=>'Example Txt....',
                    'class'=>'fav'
                ]
            ])
            ->add('titre',TextType::class,[
                'label'=>'Titre : ',
                'attr'=>[
                    'placeholder'=>'Example Txt....',
                    'class'=>'titre'
                ]
            ])
            ->add('evaluation',NumberType::class,[
                'label'=>'evaluation : ',
                'attr'=>[
                    'placeholder'=>'2.0',
                    'class'=>'evaluation'
                ]
            ])
            ->add('image',FileType::class,[
                'mapped'=>false,
                'label'=>'image : ',
                'attr'=>[
                    'placeholder'=>'lien de l image du livre ',
                    'class'=>'img'
                ]
            ])
            /*->add('idC',EntityType::class,[
                'label'=>'id du citaiton : ',
                'attr'=>[
                    'placeholder'=>'numero du citation a associer a ce livre .. ',
                    'class'=>'idc'
                ]
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EBooks::class,
        ]);
    }
}

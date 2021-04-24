<?php

namespace App\Form;

use App\Entity\Coach;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class CoachType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class,array(
                'label'=>'Nom Coach',
                'attr'=>[
                    'placeholder'=>'Ben Foulen....'
                ]
            ))
            ->add('prenom', TextType::class,array(
                'label'=>'Prenom Coach',
                'attr'=>[
                    'placeholder'=>'Foulen....'
                ]
            ))
            ->add('email', TextType::class,array(
                'label'=>'Email',
                'attr'=>[
                    'placeholder'=>'Foulen.benFoulen@yahoo.fr'
                ]
            ))
            
            ->add('tel')
            ->add('adresse',TextareaType::class)
            
            ->add('image', FileType::class, [
                'mapped' => false
            ])
            
            ->add('date',DateType::class, array(
                'widget'=>'single_text',
                'format'=>'yyyy-MM-dd'
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Coach::class,
        ]);
    }
}

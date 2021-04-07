<?php

namespace App\Form;

use App\Entity\Tache;
use Doctrine\DBAL\Types\DateTimeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType as TypeDateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TacheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('typeTache', ChoiceType::class, [
                'choices'  => [
                    'video'=>'video',
                    'e_books' => 'e_books',
                    'citation' => 'citation',
                    'musique' => 'musique',
                ],
            ])
            
            ->add('nomTache')
            
            ->add('Enregistrer', SubmitType::class, [
                'attr' => ['class' => 'save'],
            ]);
            
           
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tache::class,
        ]);
    }
}

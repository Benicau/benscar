<?php

namespace App\Form;

use App\Entity\Car;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('marque', TextType::class, [
                'label'=>'Marque',
                'attr'=>[
                    'placeholder' => "Marque"
                ]
            ])

            ->add('modele', TextType::class, [
                'label'=>'Modele',
                'attr'=>[
                    'placeholder' => "Modele"
                ]
            ]) 
            ->add('prix')
            ->add('nbrpoprio')
            ->add('kilometres')
            ->add('cylindree')
            ->add('puissance')
            ->add('carburant')
            ->add('transmition')
            ->add('description')
            ->add('optioncar')
            ->add('coverImage', UrlType::class, [
                'label'=>'cover',
                'attr'=>[
                    'placeholder' => "Url image"
                ]
            ]) 
            

            ->add('miseEnCirculation')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}

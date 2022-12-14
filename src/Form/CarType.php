<?php

namespace App\Form;

use App\Entity\Car;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Form\DataTransformer\FrenchToDateTimeTransformer;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CarType extends ApplicationType
{
        private $transformer;
        /**
         * Function who transform date in string value
         *
         * @param FrenchToDateTimeTransformer $transformer
         */
        public function __construct(FrenchToDateTimeTransformer $transformer)
            {
        $this->transformer = $transformer;
             }

    /**
     * Form add and update for car
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('marque', TextType::class, [
                'label'=>'Marque',
                'attr'=>[
                    'placeholder' => "Marque"
                ]
            ])

            ->add('marque', TextType::class, $this->getConfiguration("Marque","Donnez la marque de la voiture")) 
            ->add('modele', TextType::class, $this->getConfiguration("Modèle","Donnez le modèle de la voiture")) 
            ->add('prix', MoneyType::class, $this->getConfiguration("Prix","Donnez le prix de vente de la voiture"))
            ->add('nbrpoprio', IntegerType::class, $this->getConfiguration("Propriétaire", "Nombre d'ancien propriétaire de la voiture"))
            ->add('kilometres',IntegerType::class, $this->getConfiguration("Kilomètres", "Nombre de kilometres de la voiture"))
            ->add('cylindree', TextType::class, $this->getConfiguration("Cylindree","Donnez la cylindrée de la voiture")) 
            ->add('puissance', TextType::class, $this->getConfiguration("Puissance","Donnez la puissance de la voiture")) 
            ->add('carburant', ChoiceType::class,['choices' =>['Essence' =>'Essence', 'Diesel'=>'Diesel','Lpg'=>'Lpg', 'Electrique'=>'Electrique']],$this->getConfiguration("Carburant de la voiture","Choisir"))
            ->add('transmition', ChoiceType::class,['choices' =>['Manuelle' =>'Manuelle', 'Automatique'=>'Automatique']],$this->getConfiguration("Transmission de la voiture","Choisir"))
            ->add('description',TextareaType::class, $this->getConfiguration("Description de la voiture","Description de la voiture")) 
            ->add('optioncar',TextareaType::class, $this->getConfiguration("Option de la voiture","Donnez les différentes option de la voiture")) 
            ->add('miseEnCirculation',TextType::class, $this->getConfiguration("Date de mise en circulation", "La date de mise en circulation"))
            ->add('coverImage', FileType::class, array('data_class' => null))
           ->add('images',FileType::class,[
               'label'=>'Gallerie de photos',
               'multiple'=>true,
               'mapped'=>false,
               'required'=>true,
               'attr'=>['class' =>'form-control']
            ])
            
        ;
        $builder->get('miseEnCirculation')->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Car::class
        ]);
    }
}

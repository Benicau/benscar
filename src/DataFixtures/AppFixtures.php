<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Car;
use App\Entity\Image;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class AppFixtures extends Fixture
{
   
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
      
        for($i = 1; $i <= 30; $i++)
        {
            $car = new Car();
            $option = $faker->paragraph(2);
            $description = '<p>'.join('</p><p>', $faker->paragraphs(5)).'</p>';
            $carburantTab = ['essence','diesel','lpg','electrique'];
            $carburant = $carburantTab[rand(0,3)];
            $transmissionTab = ['boite de vitesse manuel','boite de vitesse automatique','lpg','electrique'];
            $transmission = $transmissionTab[rand(0,1)];
            $misecirculation = $faker->dateTimeThisDecade();
            
            

            

            $car->setMarque($faker->word())
            ->setModele($faker->word())
                ->setPrix(rand(5000,40000))
                ->setNbrpoprio(rand(1,5))
                ->setKilometres(rand(1000,500000))
                ->setCylindree($faker->bothify('#### ccm'))
                ->setPuissance($faker->bothify('### CV / ### kW'))
                ->setCarburant($carburant)
                ->setTransmition($transmission)
                ->setDescription($description)
                ->setOptioncar($option)
                ->setMiseEnCirculation($misecirculation)                
                ;

            $manager->persist($car);

            // gestion de l'image de l'annonce
         //   for($j=1; $j<= rand(2,5); $j++)
          //  {
           //     $image = new Image();
            //    $image->setLien('https://picsum.photos/200/200')
             //       ->setCar(rand(1,5));
              //  $manager->persist($image);    
           // }

        }


        $manager->flush();
    }
}
<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Car;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{


    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher) 
    {
        $this->hasher = $hasher;
    }

   
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
            $transmissionTab = ['Manuelle','Automatique'];
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
                ->setCoverImage('https://picsum.photos/350/180')             
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

        //users
        for ($i=0; $i<10; $i++) { 
            $user = new User();
            $user->setFullName($faker->name())
                ->setPseudo(mt_rand(0,1) === 1 ? $faker->firstname() : null)
                ->setEmail($faker->email())
                ->setRoles(['ROLE_USER']);
            $hashPassword = $this->hasher->hashPassword(
                $user,
                'password'
            );            
            $user->setPassword($hashPassword);
            $manager->persist($user);
        }
        

 
        $manager->flush();
    }
}
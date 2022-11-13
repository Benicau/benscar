<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Car;
use App\Entity\User;
use App\Entity\Image;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{


    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

   
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');


         // gestion des utilisateurs
         $users = []; // init un tableau pour récup les user pour les Cars
        

        //users
        for ($i=0; $i<10; $i++) { 
            $user = new User();
            $hash = $this->passwordHasher->hashPassword($user,'password');

            $user->setFirstName($faker->firstName())
                ->setLastName($faker->lastName())
                ->setEmail($faker->email())
                ->setPassword($hash)
                ->setPseudo($faker->word())  
                ->setRoles(['ROLE_ADMIN']) 
                ;

            $manager->persist($user);
            $users[] = $user;    
        }



        for($i = 1; $i <= 30; $i++)
        {
            $car = new Car();
            $option ='<p>'.join('</p><p>', $faker->paragraphs(2)).'</p>';
            $description =  '<p>'.join('</p><p>', $faker->paragraphs(5)).'</p>';
            $carburantTab = ['essence','diesel','lpg','electrique'];
            $carburant = $carburantTab[rand(0,3)];
            $transmissionTab = ['Manuelle','Automatique'];
            $transmission = $transmissionTab[rand(0,1)];
            $misecirculation = $faker->dateTimeThisDecade();

             // liaison avec user
             $user = $users[rand(0, count($users)-1)];
            
            

            

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
                ->setAuthor($user)          
                ;

            $manager->persist($car);

            
            // gestion de l'image de l'annonce
           for($j=1; $j<= rand(2,5); $j++)
            {
                $image = new Image();
                $image->setUrl('https://picsum.photos/450/250')
                ->setCaption($faker->sentence())
                ->setCar($car);
                $manager->persist($image);    
            }

        }

        $manager->flush();
    }
}
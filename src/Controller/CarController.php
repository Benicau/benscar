<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\CarType;
use Doctrine\ORM\EntityManager;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class CarController extends AbstractController
{
    /**
     * This function display all cars
     *
     * @param CarRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/car', name: 'app_car', methods: ['GET'])]
    public function index(CarRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $cars = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            6
        );
        return $this->render('pages/car/index.html.twig', [
            'cars'=>$cars     
        ]);
    }


    /**
     * this function display all car in administration
     *
     * @param CarRepository $repository
     * @return Response
     */
    #[Route('/admin', name: 'admin_car', methods: ['GET'])]
    #[Security("is_granted('ROLE_ADMIN')")]
    public function admin(CarRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {

        $cars = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            15
        );
        return $this->render('pages/admin/index.html.twig', [
            'cars'=>$cars     
        ]);
    }

    /**
     * this function go to form new car in admin
     *
     * @return Response
     */
    #[Route('/new', name: 'new_car', methods: ['GET','POST'])]
    #[Security("is_granted('ROLE_ADMIN')")]
    public function new(EntityManagerInterface $manager, Request $request) : Response
    {


        $cars = new Car();
        $form = $this->createForm(CarType::class, $cars);
        $form->handleRequest($request);
        

        if($form->isSubmitted() && $form->isValid())
        {
            // add author on new car
            $cars->setAuthor($this->container->get('security.token_storage')->getToken()->getUser()); 
           // gestion de mon image
           $file = $form['coverImage']->getData();
           if(!empty($file))
           {
               $originalFilename = pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME);
               $safeFilename = transliterator_transliterate('Any-Latin;Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
               $newFilename = $safeFilename."-".uniqid().".".$file->guessExtension();
               try{
                   $file->move(
                       $this->getParameter('uploads_directory'),
                       $newFilename
                   );
               }catch(FileException $e)
               {
                   return $e->getMessage();
               }
               $cars->setCoverImage($newFilename);
           }
           $manager->persist($cars);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre voiture a bien été créé"
            );

        }

        return $this->render('pages/car/new.html.twig',['form'=>$form->createView()]);
    }




 /**
  * this function delete car in admin panel
  */
    #[Route("/car/{slug}/delete", name:"car_delete")]
    #[Security("is_granted('ROLE_ADMIN')")]
    public function delete(Car $car, EntityManagerInterface $manager)
    {
        $this->addFlash('success', "La voiture {$car->getId()} a bien été supprimée");
        $manager->remove($car);
        $manager->flush();

        return $this->redirectToRoute('admin_car');
    }



















    /**
     * Permet d'afficher une annonce via son slug
     */
    #[Route('/car/{slug}', name:'cars_show')]
    public function show(string $slug, Car $car):Response
    {
        dump($car);

        return $this->render('pages/car/show.html.twig',[
            'car' => $car
        ]);
    }


}


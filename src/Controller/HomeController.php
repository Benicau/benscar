<?php

namespace App\Controller;

use App\Repository\CarRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * home page
     *
     * @param CarRepository $repository
     * @param Request $request
     * @return Response
     */
    #[Route('/', name: 'homepage', methods: ['GET'])]
    public function index(CarRepository $repository, Request $request): Response
    {

        $cars = $repository->findBy([],['id'=>'DESC'],6);

        return $this->render('pages/home.html.twig', [
            'controller_name' => 'HomeController',
            'cars'=>$cars
        ]);
    }
}
<?php

namespace App\Controller;

use App\Repository\CarRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
}

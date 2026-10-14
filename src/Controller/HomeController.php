<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\RecetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(RecetteRepository $recettes, CategorieRepository $categories): Response
    {
        return $this->render('home/index.html.twig', [
            'dernieres'   => $recettes->findDernieres(6),
            'mieuxNotees' => $recettes->findMieuxNotees(6),
            'categories'  => $categories->findBy([], ['description2' => 'ASC']),
        ]);
    }
}


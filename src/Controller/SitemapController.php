<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\RecetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SitemapController extends AbstractController
{
    #[Route('/sitemap.xml', name: 'app_sitemap', format: 'xml', methods: ['GET'])]
    public function index(
        RecetteRepository $recetteRepository,
        CategorieRepository $categorieRepository,
        UrlGeneratorInterface $urlGenerator
    ): Response {
        $abs = UrlGeneratorInterface::ABSOLUTE_URL;
        $urls = [];

        // Pages fixes
        $urls[] = ['loc' => 'https://bravocuistot-gg.fr/', 'changefreq' => 'daily', 'priority' => '1.0'];
        $urls[] = ['loc' => 'https://bravocuistot-gg.fr/recette', 'changefreq' => 'daily', 'priority' => '0.9'];
        $urls[] = ['loc' => 'https://bravocuistot-gg.fr/contact', 'changefreq' => 'yearly', 'priority' => '0.3'];
        $urls[] = ['loc' => 'https://bravocuistot-gg.fr/mentions/legales', 'changefreq' => 'yearly', 'priority' => '0.2'];

        // Catégories (pages filtrées de la liste des recettes)
        foreach ($categorieRepository->findAll() as $categorie) {
            $urls[] = [
                'loc' => 'https://bravocuistot-gg.fr/recette?categorie=' . $categorie->getId(),
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ];
        }

        // Recettes
        foreach ($recetteRepository->findBy([], ['id' => 'DESC']) as $recette) {
            $url = [
                // Adapte le nom de la route si besoin (voir : php bin/console debug:router)
                'loc' => $urlGenerator->generate('app_recette_show', ['id' => $recette->getId()], $abs),
                'changefreq' => 'monthly',
                'priority' => '0.8',
            ];
            // Si ton entité a une date de mise à jour, décommente :
            // if (method_exists($recette, 'getUpdatedAt') && $recette->getUpdatedAt()) {
            //     $url['lastmod'] = $recette->getUpdatedAt()->format('Y-m-d');
            // }
            $urls[] = $url;
        }

        $response = $this->render('sitemap/index.xml.twig', ['urls' => $urls]);
        $response->headers->set('Content-Type', 'application/xml; charset=UTF-8');
        $response->setPublic();
        $response->setMaxAge(3600);

        return $response;
    }
}

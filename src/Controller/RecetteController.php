<?php

namespace App\Controller;

use App\Entity\Recette;
use App\Form\RecetteForm;
use App\Repository\RecetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/recette')]
final class RecetteController extends AbstractController
{
// src/Controller/RecetteController.php

#[Route('', name: 'app_recette_index', methods: ['GET'])]
public function index(
    Request $request,
    RecetteRepository $recetteRepository
): Response {
    $fiche = $request->query->get('fiche');

    // Si un nom est saisi, on filtre.
    // Sinon, on récupère toutes les recettes.
    if ($fiche) {
        $recetteRepository->findBy(['fiche' => $fiche]);
    } else {
        $recettes = $recetteRepository->findAll();
    }

    return $this->render('recette/index.html.twig', [
        'recettes' => $recettes,
        'fiche' => $fiche,
    ]);
}

    #[IsGranted('ROLE_VISITEUR')]
    #[Route('/new', name: 'app_recette_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger
    ): Response {
        $recette = new Recette();

        $form = $this->createForm(RecetteForm::class, $recette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('avatar2')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo(
                    $imageFile->getClientOriginalName(),
                    PATHINFO_FILENAME
                );

                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('danger', 'Erreur lors du téléversement de l’image.');
                    return $this->redirectToRoute('app_recette_new');
                }

                $recette->setAvatar2($newFilename);
            }

            $entityManager->persist($recette);
            $entityManager->flush();

            return $this->redirectToRoute('app_recette_index');
        }

        return $this->render('recette/new.html.twig', [
            'recette' => $recette,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_recette_show', methods: ['GET'])]
    public function show(Recette $recette): Response
    {
        return $this->render('recette/show.html.twig', [
            'recette' => $recette,
        ]);
    }

    #[IsGranted('ROLE_MODERATOR')]
    #[Route('/{id}/edit', name: 'app_recette_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Recette $recette,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger
    ): Response {
        $form = $this->createForm(RecetteForm::class, $recette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('avatar2')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo(
                    $imageFile->getClientOriginalName(),
                    PATHINFO_FILENAME
                );

                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('danger', 'Erreur lors du téléversement de l’image.');
                    return $this->redirectToRoute('app_recette_edit', [
                        'id' => $recette->getId(),
                    ]);
                }

                $recette->setAvatar2($newFilename);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_recette_index');
        }

        return $this->render('recette/edit.html.twig', [
            'form' => $form->createView(),
            'recette' => $recette,
        ]);
    }

    #[IsGranted('ROLE_MODERATOR')]
    #[Route('/{id}', name: 'app_recette_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        Recette $recette,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid(
            'delete' . $recette->getId(),
            $request->request->get('_token')
        )) {
            $entityManager->remove($recette);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_recette_index');
    }
}
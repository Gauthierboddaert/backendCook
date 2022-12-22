<?php

namespace App\Controller;

use App\Entity\Recette;
use App\Form\RecetteType;
use App\Repository\RecetteRepository;
use App\Service\ImageManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/home')]
class HomePageController extends AbstractController
{
    private RecetteRepository $recetteRepository;
    private ImageManager $imageManager;
    private string $image_directory;

    public function __construct(RecetteRepository $recetteRepository, ImageManager $imageManager,string $image_directory)
    {
        $this->recetteRepository = $recetteRepository;
        $this->imageManager = $imageManager;
        $this->image_directory = $image_directory;
    }

    #[Route('/', name: 'app_home_page_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('home_page/index.html.twig', [
//            'recettes' => $this->recetteRepository->findTwelveFirstRecette(),
            'recettes' => $this->recetteRepository->findThreeLastRecette()
        ]);
    }

    #[Route('/new', name: 'app_home_page_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $recette = new Recette();
        $form = $this->createForm(RecetteType::class, $recette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->recetteRepository->save($recette, true);

            // Move image after download
            $this->imageManager->downloadImage($form, $recette,$this->recetteRepository,$this->image_directory);
            return $this->redirectToRoute('app_home_page_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('home_page/new.html.twig', [
            'recette' => $recette,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_home_page_show', methods: ['GET'])]
    public function show(Recette $recette): Response
    {
        return $this->render('home_page/show.html.twig', [
            'recette' => $recette,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_home_page_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Recette $recette): Response
    {
        $form = $this->createForm(RecetteType::class, $recette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->recetteRepository->save($recette, true);

            return $this->redirectToRoute('app_home_page_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('home_page/edit.html.twig', [
            'recette' => $recette,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_home_page_delete', methods: ['POST'])]
    public function delete(Request $request, Recette $recette): Response
    {
        if ($this->isCsrfTokenValid('delete'.$recette->getId(), $request->request->get('_token'))) {
            $this->recetteRepository->remove($recette, true);
        }

        return $this->redirectToRoute('app_home_page_index', [], Response::HTTP_SEE_OTHER);
    }
}

<?php

namespace App\Controller;

use App\Entity\Recette;
use App\Form\RecetteType;
use App\Form\SearchType;
use App\Repository\RecetteRepository;
use App\Service\ImageInterface;
use App\Service\RecetteInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/home')]
class HomePageController extends AbstractController
{
    private RecetteRepository $recetteRepository;
    private ImageInterface $imageInterface;
    private string $image_directory;
    private recetteInterface $recetteInterface;

    public function __construct(
        RecetteRepository $recetteRepository,
        ImageInterface $imageInterface,
        recetteInterface $recetteInterface,
        string $image_directory
    )
    {
        $this->recetteRepository = $recetteRepository;
        $this->imageInterface = $imageInterface;
        $this->recetteInterface = $recetteInterface;
        $this->image_directory = $image_directory;
    }

    #[Route('/', name: 'app_home_page_index', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $recette = new Recette();
        $form = $this->createForm(SearchType::class, $recette);
        $search = $this->recetteInterface->createFormRecette($request, $form, 'app_homepage_search');

        if($search instanceof RedirectResponse){
            return $this->redirectToRoute('app_homepage_search', [
                'name' => 'cc'
            ]);
        }

        return $this->renderForm('home_page/index.html.twig', [
            'recettes' => $this->recetteRepository->findThreeLastRecette(),
            'form' => $search
        ]);
    }

    #[Route('/search', name: 'app_homepage_search', methods: ['GET', 'POST'])]
    public function searchRecette(Request $request): Response
    {
        return $this->renderForm('Search/index.html.twig', [

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

            // Move image
            $this->imageInterface->downloadImage($form, $recette,$this->recetteRepository,$this->image_directory);
            return $this->redirectToRoute('app_home_page_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('home_page/new.html.twig', [
            'recette' => $recette,
            'form' => $form
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
            //move the image
            $this->imageInterface->downloadImage($form, $recette,$this->recetteRepository,$this->image_directory);
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

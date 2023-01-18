<?php

namespace App\Controller;

use App\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private RecipeRepository $recetteRepository;
    public function __construct(RecipeRepository $recetteRepository)
    {
        $this->recetteRepository = $recetteRepository;
    }

    #[Route('/user/favories', name: 'app_user_favories')]
    public function index(): Response
    {
        return $this->render('favoris/index.html.twig', [
            'favoris' => $this->recetteRepository->findFavoriesByUser(),
        ]);
    }
}

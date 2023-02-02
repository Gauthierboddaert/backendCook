<?php

namespace App\Controller;

use App\Repository\RecipeRepository;
use App\Service\UserManager;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    private RecipeRepository $recipeRepository;
    private UserManager $userManager;
    public function __construct(RecipeRepository $recipeRepository, UserManager $userManager)
    {
        $this->recipeRepository = $recipeRepository;
        $this->userManager = $userManager;
    }

    #[Route('/profil', name: 'app_user_index')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        if(null == $this->getUser())
        {
            return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);

        }

        return $this->render('user/index.html.twig', [
            'user' => $this->getUser(),
            'recettes' => $this->recipeRepository->findTenLastObject(),
            'age' => $this->userManager->getAge($this->getUser())
        ]);
    }
}

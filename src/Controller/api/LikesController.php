<?php

namespace App\Controller\api;

use App\Repository\LikeRepository;
use App\Repository\LikeRepositoryInterface;
use App\Repository\RecipeRepository;
use App\Repository\RecipeRepositoryInterface;
use App\Service\LikeManagerInterface;
use App\Service\LikeManagerManager;
use App\Service\RecipeManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class  LikesController extends AbstractController
{

    private LikeManagerInterface $likeInterface;

    public function __construct(
        LikeManagerInterface $likeInterface
    )
    {
        $this->likeInterface = $likeInterface;
    }

    #[Route('/api/likes/recette/{id}',name: 'app_likes',methods: ['POST'])]
    public function index(int $id): JsonResponse
    {
        $this->likeInterface->LikeRecipe($id);

        return new JsonResponse('',Response::HTTP_OK);
    }
}

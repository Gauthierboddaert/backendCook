<?php

namespace App\Controller\api;

use App\Repository\LikeRepository;
use App\Repository\LikeRepositoryInterface;
use App\Repository\RecetteRepository;
use App\Repository\RecetteRepositoryInterface;
use App\Service\LikeInterface;
use App\Service\LikeManager;
use App\Service\RecetteInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class  LikesController extends AbstractController
{

    private LikeInterface $likeInterface;

    public function __construct(
        LikeInterface $likeInterface
    )
    {
        $this->likeInterface = $likeInterface;
    }

    #[Route('/api/likes/recette/{id}',name: 'app_likes',methods: ['POST'])]
    public function index(int $id): JsonResponse
    {
        $this->likeInterface->LikeRecette($id);

        return new JsonResponse('',Response::HTTP_OK);
    }
}

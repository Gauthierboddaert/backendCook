<?php

namespace App\Controller\api;

use App\Repository\RecetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api')]
class RecetteController extends AbstractController
{
    private RecetteRepository $recetteRepository;
    private SerializerInterface $serializer;
    public function __construct(RecetteRepository $recetteRepository, SerializerInterface $serializer)
    {
        $this->recetteRepository = $recetteRepository;
        $this->serializer = $serializer;
    }

    #[Route('/recette', name: 'app_recette')]
    public function index(): JsonResponse
    {
        return new JsonResponse(
            $this->serializer->serialize($this->recetteRepository->findAll(),
            'json', ["groups" => "getRecette"]),
            Response::HTTP_OK,
            [],
            true
        );
    }
}

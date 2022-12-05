<?php

namespace App\Controller\api;

use App\Repository\RecetteRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    private EntityManagerInterface $entityManager;
    private SerializerInterface $serializer;
    public function __construct(RecetteRepository $recetteRepository, SerializerInterface $serializer, EntityManagerInterface $entityManager)
    {
        $this->recetteRepository = $recetteRepository;
        $this->serializer = $serializer;
        $this->entityManager = $entityManager;
    }

    #[Route('/recette', name: 'app_recette', methods: 'GET')]
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

    #[Route('/recette/{id}', name: 'app_one_recette', methods: 'GET')]
    public function findOneRecette(int $id): JsonResponse
    {
        $recette = $this->recetteRepository->findOneBy(['id' => $id]);

        if(null === $recette)
            return new JsonResponse($this->serializer->serialize("Recette doesn't exist",'json'),Response::HTTP_BAD_REQUEST, [], true);

        return new JsonResponse(
            $this->serializer->serialize($recette,
                'json', ["groups" => "getRecette"]),
            Response::HTTP_OK,
            [],
            true
        );
    }

    #[Route('/recette/{id}', name: 'app_one_recette', methods: 'DELETE')]
    public function deleteRecette(int $id): JsonResponse
    {
        $recette = $this->recetteRepository->findOneBy(['id' => $id]);
//        dd($recette);
        if(null === $recette)
            return new JsonResponse($this->serializer->serialize("Recette doesn't exist",'json'),Response::HTTP_BAD_REQUEST, [], true);

        $this->recetteRepository->remove($recette);
        $this->entityManager->flush();
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);

    }
}

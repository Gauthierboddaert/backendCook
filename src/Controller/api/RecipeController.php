<?php

namespace App\Controller\api;

use App\Entity\Category;
use App\Entity\Recipe;
use App\Repository\CategoryRepository;
use App\Repository\RecipeRepository;
use App\Repository\UserRepository;
use App\Service\RecipeManager;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Util\Json;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;

#[Route('/api')]
class RecipeController extends AbstractController
{
    private RecipeRepository $recipeRepository;
    private EntityManagerInterface $entityManager;
    private SerializerInterface $serializer;
    private UserRepository $userRepository;
    private CategoryRepository $categoryRepository;
    private RecipeManager $recipeManager;

    public function __construct(
        CategoryRepository     $categoryRepository,
        UserRepository         $userRepository,
        RecipeRepository       $recipeRepository,
        SerializerInterface    $serializer,
        EntityManagerInterface $entityManager,
        RecipeManager $recipeManager
    )
    {
        $this->recipeRepository = $recipeRepository;
        $this->categoryRepository = $categoryRepository;
        $this->serializer = $serializer;
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->recipeManager = $recipeManager;
    }

    #[Route('/recipe', name: 'app_recipe', methods: 'GET')]
    public function index(): JsonResponse
    {
        return new JsonResponse(
            $this->serializer->serialize($this->recipeRepository->findAll(),
            'json', ["groups" => "getRecette"]),
            Response::HTTP_OK,
            [],
            true
        );
    }

    #[Route('/recipe/{id}', name: 'app_one_recipe', methods: 'GET')]
    public function findOneRecette(int $id): JsonResponse
    {
        $recipe = $this->recipeRepository->findOneBy(['id' => $id]);

        if(null === $recipe)
            return new JsonResponse($this->serializer->serialize("Recipe doesn't exist",'json'),Response::HTTP_BAD_REQUEST, [], true);

        return new JsonResponse(
            $this->serializer->serialize($recipe,
                'json', ["groups" => "getRecette"]),
            Response::HTTP_OK,
            [],
            true
        );
    }

    #[Route('/recipe/{id}', name: 'app_delete_recipe', methods: 'DELETE')]
    public function deleteRecette(int $id): JsonResponse
    {
        $recipe = $this->recipeRepository->findOneBy(['id' => $id]);
//        dd($recipe);
        if(null === $recipe)
            return new JsonResponse($this->serializer->serialize("Recipe doesn't exist",'json'),Response::HTTP_BAD_REQUEST, [], true);

        $this->recipeRepository->remove($recipe);
        $this->entityManager->flush();
        return new JsonResponse(
            null,
            Response::HTTP_NO_CONTENT
        );

    }

    #[Route('/recipe', name: 'app_post_recipe', methods: 'POST')]
    public function postRecette(Request $request): JsonResponse
    {
         $request = $request->toArray();

         $recipe = new Recipe();
         $recipe->setName($request['name']);
         $recipe->setDescriptions($request['description']);
         $recipe->setUsers($this->userRepository->findOneBy(['email' => $request['email']]));
         $recipe->addCategory($this->categoryRepository->findOneBy(['name' => $request['category']]));
         $this->recipeRepository->save($recipe, true);

         return new JsonResponse($this->serializer->serialize(
             'You have add a new Recipe :) !'
             ,'json',[]),
             Response::HTTP_CREATED,
             [],
             true);
    }

    #[Route('/recipe/{id}', name: 'app_update_recipe', methods: 'PUT')]
    public function updateRecette(int $id, Request $request) : JsonResponse
    {
        $request = $request->toArray();
        $recipe = $this->recipeRepository->findOneBy(['id' => $id]);
        $category = $this->categoryRepository->findOneBy(['name' => $request['category']]);

        ( !empty($request['name'])) ? $recipe->setName($request['name']) : '' ;
        (!empty($request['description'])) ? $recipe->setDescriptions($request['description']) : '';
        (!empty($request['category'])) ? $this->recipeManager->setNewCategory($category, $recipe) : '';

        $this->recipeRepository->save($recipe, true);

        return new JsonResponse();
    }

}

<?php

namespace App\Service;

use App\Entity\Category;
use App\Entity\Favoris;
use App\Entity\Like;
use App\Entity\Recipe;
use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Repository\RecipeRepository;
use App\Repository\RepositoryInterface;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class RecipeManager implements RecipeManagerInterface
{
    private RecipeRepository $recipeRepository;
    private UserRepository $userRepository;
    private ImageManagerInterface $imageManager;
    private string $image_directory;
    private RepositoryInterface $repository;
    private EntityManagerInterface $entityManager;
    private IngredientManager $ingredientManager;
    private CategoryManager $categoryManager;
    private RecipeStepManager $recipeStepManager;

    public function __construct
    (
        RecipeRepository $recipeRepository,
        ImageManagerInterface $imageManager,
        RepositoryInterface $repository,
        EntityManagerInterface $entityManager,
        UserRepository $userRepository,
        IngredientManager $ingredientManager,
        CategoryManager $categoryManager,
        RecipeStepManager $recipeStepManager,
        string $image_directory,

    )
    {
        $this->recipeRepository = $recipeRepository;
        $this->imageManager = $imageManager;
        $this->image_directory = $image_directory;
        $this->repository = $repository;
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->ingredientManager = $ingredientManager;
        $this->categoryManager = $categoryManager;
        $this->recipeStepManager = $recipeStepManager;
    }

    public function setNewCategory(Category $category , Recipe $recette) : void
    {
        $recette->removeCategory($recette->getCategory()[0]);
        $recette->addCategory($category);
    }

    public function createNewRecipe(Recipe $recipe,User $user, FormInterface $form ) : bool
    {
        $like = new Like();
        $like->setUser($user);
        $like->setIsLike(false);
        $like->setRecipe($recipe);

        $favoris = new Favoris();
        $favoris->setIsFavoris(false);
        $favoris->addUser($user);
        $favoris->addRecette($recipe);

        //set the user here like this I don't need to show it in the form
        $recipe->setUsers($user);

        //allow to move image in directory of project uploads/image_recipe
        $this->imageManager->downloadImage($form, $recipe,$this->recipeRepository);

        $this->entityManager->persist($recipe);
        $this->entityManager->persist($like);
        $this->entityManager->persist($favoris);

        $this->entityManager->flush();

        return true;
    }


    public function paginatorForTenRecipe(Request $request,array $array) : SlidingPagination
    {
        return $this->paginator->paginate(
            $array,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 9)
        );
    }

    public function createRecipeFromRequest(array $request): void
    {
        $recipe = new Recipe();
        $recipe->setName($request['name']);
        $recipe->setDescriptions($request['description']);
        //$recipe->setUsers($this->userRepository->findOneBy($this->>getUser())));
        $recipe->setUsers($this->userRepository->findOneBy(['email' => $request['email']]));
        $recipe->setNumberOfPersons($request['number_of_persons']);
        $this->ingredientManager->addIngredientsInRecipe($recipe,$request['ingredients'] );
        $this->categoryManager->addCategoryInRecipe($recipe, $request['categories']);
        $this->recipeStepManager->addRecipeStepsInRecipe($recipe, $request['steps']);
        $recipe->setCreatedAt(new \DateTime());
        $recipe->setCreationTime(10);
        $recipe->setUpdatedAt(new \DateTime());
        $this->recipeRepository->save($recipe, true);
    }

}
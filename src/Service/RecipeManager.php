<?php

namespace App\Service;

use App\Entity\Category;
use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Form\SearchType;
use App\Repository\RecipeRepository;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

class RecipeManager implements RecipeManagerInterface
{

    private RouterInterface $router;
    private RecipeRepository $recipeRepository;
    private ImageManagerInterface $imageManager;
    private string $image_directory;

    public function __construct
    (
        RouterInterface $router,
        RecipeRepository $recipeRepository,
        ImageManagerInterface $imageManager,
        string $image_directory
    )
    {
        $this->router = $router;
        $this->recipeRepository = $recipeRepository;
        $this->imageManager = $imageManager;
        $this->image_directory = $image_directory;
    }

    public function setNewCategory(Category $category , Recipe $recette) : void
    {
        $recette->removeCategory($recette->getCategory()[0]);
        $recette->addCategory($category);
    }

    public function createNewRecipe(Recipe $recipe, FormInterface $form ) : bool
    {
        $this->recipeRepository->save($recipe, true);

        //allow to move image in directory of project uploads/image_recipe
        $this->imageManager->downloadImage($form, $recipe,$this->recipeRepository,$this->image_directory);

        return true;
    }


}
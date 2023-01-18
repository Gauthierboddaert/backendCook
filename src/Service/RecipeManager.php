<?php

namespace App\Service;

use App\Entity\Category;
use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Form\SearchType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

class RecipeManager
{

    private RouterInterface $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function setNewCategory(Category $category , Recipe $recette) : void
    {
        $recette->removeCategory($recette->getCategory()[0]);
        $recette->addCategory($category);
    }


}
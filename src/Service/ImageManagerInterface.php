<?php

namespace App\Service;

use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use Symfony\Component\Form\FormInterface;

interface ImageManagerInterface
{
    public function downloadImage(FormInterface $form, Recipe $recette, RecipeRepository $recetteRepository, string $path) : void;
}
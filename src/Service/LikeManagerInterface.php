<?php

namespace App\Service;

use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use Symfony\Component\Form\FormInterface;

interface LikeManagerInterface
{
    public function LikeRecette(int $id) : void;
}
<?php

namespace App\Service;


use App\Entity\Recipe;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

interface RecipeManagerInterface
{
    public function searchRecette(Request $request,string $redirect) : mixed;

}
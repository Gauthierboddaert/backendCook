<?php

namespace App\Service;


use App\Entity\Recette;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

interface RecetteInterface
{
    public function searchRecette(Request $request,string $redirect) : mixed;

}
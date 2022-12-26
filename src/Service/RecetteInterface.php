<?php

namespace App\Service;


use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

interface RecetteInterface
{
    public function searchRecette(Request $request,string $redirect) : mixed;
}
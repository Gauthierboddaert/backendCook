<?php

namespace App\Service;


use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

interface RecetteInterface
{
    public function createFormRecette(Request $request, FormInterface $form,  string $redirect) : mixed;
    public function search();
}
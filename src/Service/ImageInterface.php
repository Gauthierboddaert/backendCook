<?php

namespace App\Service;

use App\Entity\Recette;
use App\Repository\RecetteRepository;
use Symfony\Component\Form\FormInterface;

interface ImageInterface
{
    public function downloadImage(FormInterface $form, Recette $recette, RecetteRepository $recetteRepository, string $path) : void;
}
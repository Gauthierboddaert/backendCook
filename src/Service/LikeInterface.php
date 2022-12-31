<?php

namespace App\Service;

use App\Entity\Recette;
use App\Repository\RecetteRepository;
use Symfony\Component\Form\FormInterface;

interface LikeInterface
{
    public function LikeRecette(int $id) : void;
}
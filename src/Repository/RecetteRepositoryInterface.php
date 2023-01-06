<?php

namespace App\Repository;

use App\Entity\Recette;

interface RecetteRepositoryInterface
{
    public function findTopThreeBestLikedRecipe() : ?array;
}
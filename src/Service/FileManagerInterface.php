<?php

namespace App\Service;

use App\Entity\Recipe;

interface FileManagerInterface
{
    public function moveFileInDirectory($img, string $path, Recipe $recipe) : void;
}
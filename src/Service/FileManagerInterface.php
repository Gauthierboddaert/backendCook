<?php

namespace App\Service;

interface FileManagerInterface
{
    public function moveFileInDirectory($img, string $path, Recette $recipe) : void;
}
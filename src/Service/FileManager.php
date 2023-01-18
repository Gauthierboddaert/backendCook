<?php

namespace App\Service;

use App\Entity\Image;
use App\Entity\Recipe;

class FileManager implements FileManagerInterface
{
    public function moveFileInDirectory($img, string $path, Recette $recipe): void
    {
        $fichier = $this->generateFileName($img);

        if(null === $fichier)
        {
            $img->move(
                $path, $fichier
            );

            $fileImage = new Image();
            $fileImage->setName($fichier);
            $recipe->setImage($fileImage);
        }
    }

    private function generateFileName($img) : ?string
    {
         return uniqid().".".$img->guessExtension();
    }
}
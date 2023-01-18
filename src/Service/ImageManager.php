<?php

namespace App\Service;

use App\Entity\Image;
use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use Symfony\Component\Form\FormInterface;

class ImageManager implements ImageManagerInterface
{
    private FileManagerInterface $fileManager;

    public function __construct(FileManagerInterface $fileManager)
    {
        $this->fileManager = $fileManager;
    }

    public function downloadImage(FormInterface $form, Recipe $recipe, RecipeRepository $recetteRepository, string $path) : void
    {
        $image = $form->get('images') ->getData();
        foreach($image as $img){
            $this->fileManager->moveFileInDirectory($img, $path, $recipe);
        }

        $recetteRepository->save($recipe, true);
    }


}
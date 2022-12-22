<?php

namespace App\Service;

use App\Entity\Image;
use App\Entity\Recette;
use App\Repository\RecetteRepository;
use Symfony\Component\Form\FormInterface;

class ImageManager
{

    public function downloadImage(FormInterface $form, Recette $recette, RecetteRepository $recetteRepository, string $path) : void
    {
        $image = $form->get('images') ->getData();
        foreach($image as $img){
            $fichier = uniqid().".".$img->guessExtension();

            $img->move(
                $path, $fichier
            );

            $fileImage = new Image();
            $fileImage->setName($fichier);
            $recette->addImage($fileImage);

        }
        $recetteRepository->save($recette, true);
    }

}
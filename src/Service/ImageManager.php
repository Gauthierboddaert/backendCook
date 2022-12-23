<?php

namespace App\Service;

use App\Entity\Image;
use App\Entity\Recette;
use App\Repository\RecetteRepository;
use Symfony\Component\Form\FormInterface;

class ImageManager implements ImageInterface
{
    public function downloadImage(FormInterface $form, Recette $recette, RecetteRepository $recetteRepository, string $path) : void
    {

        $image = $form->get('images') ->getData();
        foreach($image as $img){
            $imgPath = $path."\\".uniqid().".".$img->guessExtension();

            //$fichier = ($img->guessExtension() !== 'heic') ? uniqid().".".$img->guessExtension() : $this->transformExtension($imgPath, 'jpg');
            $fichier = uniqid().".".$img->guessExtension();

            $img->move(
                $path, $fichier
            );

            $fileImage = new Image();
            $fileImage->setName($fichier);
            $recette->setImage($fileImage);

        }
        $recetteRepository->save($recette, true);
    }


}
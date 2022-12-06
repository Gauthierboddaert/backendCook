<?php

namespace App\Service;

use App\Entity\Category;
use App\Entity\Recette;
use App\Repository\CategoryRepository;
use App\Repository\RecetteRepository;

class RecetteManager
{


    public function setNewCategory(Category $category ,Recette $recette) : void
    {
        $recette->removeCategory($recette->getCategory()[0]);
        $recette->addCategory($category);
    }

}
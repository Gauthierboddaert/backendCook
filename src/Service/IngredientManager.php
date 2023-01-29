<?php

namespace App\Service;

use App\Entity\Ingredient;
use function PHPUnit\Framework\isEmpty;

class IngredientManager
{
    public function addIngredientsFromXlsx(array $data) : bool
    {
        if(isEmpty($data)){
            return false;
        }

        foreach ($data as $row){
            if(null !== $row[0])
            {
                try{
                    $ingredient = new Ingredient();
                    $ingredient->setName($row[0]);
                    $this->entityManager->persist($ingredient);
                }catch (\Exception $e){
                    return false;
                }

            }
        }

        $this->entityManager->flush();

        return true;
    }
}
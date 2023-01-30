<?php

namespace App\Service;

use App\Entity\Ingredient;
use Doctrine\ORM\EntityManagerInterface;
use function PHPUnit\Framework\isEmpty;

class IngredientManager
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function addIngredientsFromXlsx(array $data) : bool
    {
        foreach ($data as $row){
            if(null !== $row[0])
            {
                try{
                    $ingredient = new Ingredient();
                    $ingredient->setName($row[0]);
                    $ingredient->setProteines(intval($row[1]));
                    $ingredient->setGlucides(intval($row[2]));
                    $ingredient->setLipides(intval($row[3]));
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
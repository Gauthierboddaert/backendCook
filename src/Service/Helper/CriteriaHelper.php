<?php

namespace App\Service\Helper;

use App\Entity\Recette;
use Doctrine\Common\Collections\Criteria;

class CriteriaHelper
{
    public static function createFilterByRecetteName(string $name) : Criteria
    {
        return Criteria::create()
            ->where(Criteria::expr()->contains('recette.name', '%'.$name.'%'));
    }

    public static function createFilterLikeRecetteByLike(Recette $recette, $alias) : Criteria
    {
        return Criteria::create()->andWhere(
            Criteria::expr()->eq($alias, $recette)
        );
    }
}
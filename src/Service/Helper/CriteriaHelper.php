<?php

namespace App\Service\Helper;

use Doctrine\Common\Collections\Criteria;

class CriteriaHelper
{
    public static function createFilterByRecetteName(string $name) : Criteria
    {
        return Criteria::create()
            ->where(Criteria::expr()->contains('recette.name', '%'.$name.'%'));
    }
}
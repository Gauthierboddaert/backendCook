<?php

namespace App\Repository;

use App\Entity\Recette;

interface LikeRepositoryInterface
{
    public function UpdateLike(Recette $recette,bool $isLiked);
}

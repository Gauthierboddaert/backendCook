<?php

namespace App\Service;

use App\Repository\LikeRepository;
use App\Repository\LikeRepositoryInterface;
use App\Repository\RecipeRepositoryInterface;
use Doctrine\ORM\Tools\DebugUnitOfWorkListener;

class LikeManager implements LikeManagerInterface
{

    private RecipeRepositoryInterface $recetteRepositoryInterface;
    private LikeRepositoryInterface $likeRepositoryInterface;
    private LikeRepository $likeRepository;

    public function __construct(
        LikeRepository            $likeRepository,
        RecipeRepositoryInterface $recetteRepositoryInterface,
        LikeRepositoryInterface   $likeRepositoryInterface
    )
    {
        $this->recetteRepositoryInterface = $recetteRepositoryInterface;
        $this->likeRepositoryInterface = $likeRepositoryInterface;
        $this->likeRepository = $likeRepository;
    }
    public function LikeRecette(int $id) : void
    {
        $recette = $this->recetteRepositoryInterface->findOneBy([
            'id' => $id,
            'users' => 7
        ]);

        if(null !== $recette)
        {
            $like = $recette->getLikes()->first();
            $like->isIsLike() ? $like->setIsLike(false) : $like->setIsLike(true);

            $this->likeRepositoryInterface->save($like, true);
        }


    }
}
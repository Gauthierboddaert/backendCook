<?php

namespace App\Service;

use App\Repository\LikeRepository;
use App\Repository\LikeRepositoryInterface;
use App\Repository\RecetteRepositoryInterface;

class LikeManager implements LikeInterface
{

    private RecetteRepositoryInterface $recetteRepositoryInterface;
    private LikeRepositoryInterface $likeRepositoryInterface;
    private LikeRepository $likeRepository;

    public function __construct(
        LikeRepository $likeRepository,
        RecetteRepositoryInterface $recetteRepositoryInterface,
        LikeRepositoryInterface $likeRepositoryInterface
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
            'users' => 27
        ]);

        if($recette->getLikes()->first()->isIsLike())
        {
            $this->likeRepositoryInterface->UpdateLike($recette,false);
        }else{
            $this->likeRepositoryInterface->UpdateLike($recette,true);
        }
    }
}
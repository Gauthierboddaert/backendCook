<?php

namespace App\Service;

use App\Entity\Category;
use App\Entity\Recette;
use App\Form\RecetteType;
use App\Form\SearchType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

class RecetteManager implements RecetteInterface
{

    private RouterInterface $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function setNewCategory(Category $category ,Recette $recette) : void
    {
        $recette->removeCategory($recette->getCategory()[0]);
        $recette->addCategory($category);
    }

    public function createFormRecette(Request $request, FormInterface $form, string $redirect) : mixed
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $url = $this->router->generate('app_homepage_search',[
                'recetteName' => 'test'
            ]);

            return new RedirectResponse($url);
        }


        return $form;
    }

    public function search()
    {
        // TODO: Implement search() method.
    }
}
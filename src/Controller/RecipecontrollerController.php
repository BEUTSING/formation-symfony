<?php

namespace App\Controller;

use App\Repository\RecipeRepository;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RecipecontrollerController extends AbstractController


{ 
       #[Route('/recette', name: 'recette')]
    public function index(Request $request, RecipeRepository $recipeRepository ): Response {      
        
        $requet= $recipeRepository->findAll();
        // dd($requet);
        return $this->render('recipecontroller/index.html.twig',[
            'recette'=>$requet]);
    }
    
    #[Route('/recette/{slug}-{id}', name: 'show',requirements:['id'=>'\d+','slug'=>'[a-z0-9A-Z -]+'])]
    public function show(Request $request, string $slug, int $id, RecipeRepository $recipeRepository  ): Response {        
        // dd($request->attributes->get("slug"),$request->attributes->get("id"));
        $requete=$recipeRepository->find($id);
    
    //          if($requete->getSlug() !== $slug){
    //     return $this->redirectToRoute('show', [
    //         'slug'=>$requete->getSlug(),
    //         'id'=> $requete->getId() ]);
    //  }
        return $this->render('recipecontroller/show.html.twig', [
            'recette'=>$requete ]);
     }

}

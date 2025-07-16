<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeTypeForm;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RecipecontrollerController extends AbstractController

{ 
       #[Route('/recette', name: 'recette')]
    public function index(Request $request, RecipeRepository $recipeRepository ): Response {      
        
        $requet= $recipeRepository->findDuration(3);
        // dd($requet);
        return $this->render('recipecontroller/index.html.twig',[
            'recette'=>$requet]);
    }
    
    #[Route('/recette/{slug}-{id}', name: 'show',requirements:['id'=>'\d+','slug'=>'[a-z0-9A-Z -]+'])]
    public function show(Request $request, string $slug, int $id, RecipeRepository $recipeRepository  ): Response {        
        // dd($request->attributes->get("slug"),$request->attributes->get("id"));
        $requete=$recipeRepository->find($id);
    
             if($requete->getSlug() !== $slug){
        return $this->redirectToRoute('show', [
            'slug'=>$requete->getSlug(),
            'id'=> $requete->getId() ]);
     }
        return $this->render('recipecontroller/show.html.twig', [
            'recette'=>$requete ]);
     }
    #[Route('/recette/{id}/edit', name: 'recipe.edit', methods: ['GET', 'POST'])]
    public function edit(Recipe $recipe, Request $request, RecipeRepository $recipeRepository,EntityManagerInterface $em): Response
    {
        // modification du comptenu de la base de donnee
        $form = $this->createForm(RecipeTypeForm::class, $recipe);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($recipe);
            $em->flush();
            return $this->redirectToRoute('recette');}

        return $this->render('recipecontroller/edit.html.twig', [
            'recipe' => $recipe,
            'form' => $form
        ]);
    }
    #[Route('/recette/create', name: 'recipe.create')]
    public function create(Request $request, RecipeRepository $recipeRepository,EntityManagerInterface $em): Response
    {
        // craetion d'un menu
        $recipe= new Recipe();// recipe est la base de  donnee. on cree un new objet
        $form = $this->createForm(RecipeTypeForm::class, $recipe);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($recipe);
            $em->flush();
            return $this->redirectToRoute('recipe.create');
        }

        return $this->render('recipecontroller/create.html.twig', [
            'form' => $form
        ]);
    }
    #[Route('/recette/{id}/edit', name: 'recipe.delete', methods:['DELETE'])]

    public function delete(Recipe $recipe, EntityManagerInterface $em): Response  {  // suppression d'un menu
        $em->remove($recipe);
        $em->flush();
        return $this->redirectToRoute('recette');
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PremiercontrolleurController {
    #[Route("/", name:"jj")] #CEST UNE AUTRE FAÇON D'AFFICHER SUR LE NAVIGATEUR
        function index(Request $req): Response{
            // dd($req);
            return new Response("bonjour le monde!!". $req->query->get('name'));
        }

}

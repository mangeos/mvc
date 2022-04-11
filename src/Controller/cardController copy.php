<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Component\HttpFoundation\JsonResponse;

class cardController extends AbstractController
{
    /**
     * @Route("/card")
     */
    public function jsonss(): Response
    {
     
        $title = "Cards undersidor";
        
        return $this->render('card/card.html.twig', [
            'title' => $title,
        ]);
    }
    
   
}

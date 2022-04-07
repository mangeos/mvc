<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class cardController extends AbstractController
{
    /**
     * @Route("/card")
     */
    public function homeCards(): Response
    {
     
        $title = "Cards undersidor";
        
        return $this->render('card/card.html.twig', [
            'title' => $title,
        ]);
    }
    
    /**
     * @Route("/card/deck")
     */
    public function startDeck(): Response
    {
        $title = "Alla Kort";
        $d = new \App\controller\Deck();
        $d->createDeck();
        $allCards = $d->cards;
        return $this->render('card/cardDeck.html.twig', [
            'title' => $title,
            'test' => $allCards
        ]);
    }

    /**
     * @Route("/card/deck/shuffle")
     */
    public function shuffleDeck(): Response
    {
        $title = "Korten är blandade";
        $d = new \App\controller\Deck();
        $d->createDeck();
        $d->shuffle();
        $allCards = $d->cards;
        return $this->render('card/cardDeck.html.twig', [
            'title' => $title,
            'test' => $allCards
        ]);
    }

}

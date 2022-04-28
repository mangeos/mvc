<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class JsonController
{
    /**
      * @Route("/card/api/deck"),
      * method = {GET}
      */
    public function numbers(): Response
    {
        $d = new \App\Deck\Deck();
        $d->createDeck();
        $allCards = $d->cards;

        return new JsonResponse($allCards);
    }
}

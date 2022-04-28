<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CardController extends AbstractController
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
        $d = new \App\Deck\Deck();
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
    public function shuffleDeck(SessionInterface $session): Response
    {
        $session->clear();
        $session->set('counter', 0);
        $title = "Korten är blandade";
        $d = new \App\Deck\Deck();
        $d->createDeck();
        $d->shuffle();
        $allCards = $d->cards;
        return $this->render('card/cardDeck.html.twig', [
            'title' => $title,
            'test' => $allCards
        ]);
    }


    /**
    * @Route(
    *      "/card/deck/draw",
    *       methods = {"GET", "POST"}
    * )
    */

    public function cardDraw(Request $request, SessionInterface $session): Response
    {
        // var_dump($session->get('cards'));
        // var_dump(count($session->get('cards')));
        $c = $session->get('counter');
        $session->set('counter', $c + 1);
        if ($session->get('counter') == 1) {
            //  var_dump($request->query->get("number"));
            # code...
            $d = new \App\Deck\Deck();
            $d->createDeck();
            $d->shuffle();

            $allCards = $d->cards;
            $session->set('cards', $allCards);

            //takes first card in the deck
            //array_pop(array_reverse($allCards));
            $oneCard = [array_splice($allCards, 0, 1)];
            // var_dump(count($allCards));

            //save session with one card lesser than before
            $session->set('cards', $allCards);
        } else {
            # code...

            //var_dump($request->query->get("number"));
            $amount = $request->query->get("number") === null ? 1 : $request->query->get("number");
            # code...
            $deletedCards = [];
            for ($i = 0; $i < $amount; $i++) {
                # code...
                $t = $session->get("cards");
                // var_dump(array_splice( $t,1,1));
                array_push($deletedCards, array_splice($t, 0, 1));
                // var_dump($deletedCards);
                $session->set('cards', $t);
            }
        }
        $r = $session->get('cards');
        //  var_dump($session->get('cards'));
        $countCardsLeft = count($r);
        $title = "Korten är blandade";
        return $this->render('card/cardDraw.html.twig', [
            'title'         => $title,
            'countCardsLeft' => $countCardsLeft,
            'onecard'       => $oneCard ?? $deletedCards
        ]);
    }
    /**
     * @Route(
     *      "/card/deck/draw/{number}",
     *       methods = {"POST","GET"}
     * )
     */

    public function cardDraw2(Request $request, SessionInterface $session, $number): Response
    {
        $c = $session->get('counter');
        $session->set('counter', $c + 1);
        if ($session->get('counter') == 1) {
            //  var_dump($number);
            # code...
            $d = new \App\Deck\Deck();
            $d->createDeck();
            $d->shuffle();

            $allCards = $d->cards;
            $session->set('cards', $allCards);

            //takes first card in the deck
            $oneCard = [array_splice($allCards, 0, $number)];
            // var_dump(count($allCards));

            //save session with one card lesser than before
            $session->set('cards', $allCards);
        } else {
            # code...
            $amount = $number;
            # code...
            $deletedCards = [];
            for ($i = 0; $i < $amount; $i++) {
                # code...
                $t = $session->get("cards");
                // var_dump(array_splice( $t,1,1));
                array_push($deletedCards, array_splice($t, 0, 1));
                // var_dump($deletedCards);
                $session->set('cards', $t);
            }
            // $countCardsLeft = count( $_SESSION["cards"]);
        }
        $r = $session->get('cards');
        $countCardsLeft = count($r);
        $title = "Korten är blandade";
        return $this->render('card/cardDraw.html.twig', [
            'title'         => $title,
            'countCardsLeft' => $countCardsLeft,
            'onecard'       => $oneCard ?? $deletedCards
        ]);
    }

    /**
        * @Route(
        *      "/card/deck/deal/{amountOfPlayers}/{amountOfCards}",
        *       methods = {"GET"},
        *       name="deal"
        * )
        */
    public function players(Request $request, SessionInterface $session, $amountOfPlayers, $amountOfCards): Response
    {
        //create deck
        $d = new \App\Deck\Deck();
        $d->createDeck();
        $d->shuffle();

        $allCards = $d->cards;
        //var_dump(count($allCards));

        $allPlayers = [];
        for ($i = 0; $i < $amountOfPlayers; $i++) {
            # code...
            $handCards = [array_splice($allCards, 0, $amountOfCards)];
            $onePlayer = new \App\Player\Player("Player" . $i + 1, $handCards);

            array_push($allPlayers, $onePlayer);
        }

        return $this->render('card/cardDeckDeal.html.twig', [
            'title'             => "test",
            'amountOfPlayers'   => $amountOfPlayers,
            'amountOfCards'     => $amountOfCards,
            'allPlayers'        => $allPlayers,
            'theRest'           => $allCards
        ]);
    }

    /**
        * @Route("/card/deck2")
        */
    public function startDeck2(): Response
    {
        $title = "Alla Kort med 2 jokrar";
        $d = new \App\Deck\DeckWith2Jokers();
        $d->createDeck();
        $d->addJokers();
        $allCards = $d->cards;
        return $this->render('card/cardDeck.html.twig', [
            'title' => $title,
            'test' => $allCards
        ]);
    }
}

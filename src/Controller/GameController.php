<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class GameController extends AbstractController
{
    /**
     * @Route("/game")
     */
    public function homeGame(): Response
    {
        $title = "Games undersidor";
        return $this->render('game/game.html.twig', [
           'title' => $title,
        ]);
    }

    /**
     * @Route("/game/doc")
     */
    public function gameDocs(): Response
    {
        $title = "Game Doc";
        return $this->render('game/gameDoc.html.twig', [
            'title' => $title,
        ]);
    }

    /**
     * @Route("/game/game21",
     * methods = {"GET", "POST"}
     * )
     */
    public function game21(Request $request, SessionInterface $session): Response
    {
        $title = "Game 21";

        if ($request->request->get('stop')) {
            # code...
            $game21 = $session->get('game');




            while ($game21->getDealer()->points < $game21->getPlayer()->points) {
                # code...
                $game21->takeOneCard("Dealer");
            }
            $calc = $game21->calculateWinner();

            $session->set('game', $game21);
        } elseif ($request->request->get('clear')) {
            # code...
            $session->clear();
            $game21 = new \App\Game\Game();
            $game21->createDeckAndShuffle();

            $game21->takeOneCard("Player");

            $session->set('game', $game21);
        } else {
            # code...
            if ($session->get('game')) {
                # code...
                $game21 = $session->get('game');

                $game21->takeOneCard("Player");


                $session->set('game', $game21);
            } else {
                # code...
                //create game21
                $game21 = new \App\Game\Game();
                $game21->createDeckAndShuffle();

                $game21->takeOneCard("Player");

                $session->set('game', $game21);
            }
        }
        # print_r($game21->getPlayer()->playerCards);
        return $this->render('game/gameBoard.html.twig', [
                'title'       => $title,
                'playersHand' => $game21->getPlayer()->playerCards,
                'playersName' => $game21->getPlayer()->name,
                'playersPoints' => $game21->getPlayer()->points,

                'calculateWinner' => $calc ?? "",

                'dealersHand' => $game21->getDealer()->playerCards ?? "",
                'dealersName' => $game21->getDealer()->name ?? "",
                'dealersPoints' => $game21->getDealer()->points ?? "",
            ]);
    }
}

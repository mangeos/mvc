<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ProjectController extends AbstractController
{
    /**
     * @Route("/proj")
     */
    public function projectStart(): Response
    {
        $url = "myfile.json";
        $json = file_get_contents($url);
        $json = json_decode($json, true);

        $title = "Presentation";
        return $this->render('project/base.html.twig', [
            'title' => $title,
            'json' => $json
        ]);
    }

    /**
     * @Route("/proj/play")
     *
     */
    public function projPlay(): Response
    {
        $url = "myfile.json";
        $json = file_get_contents($url);
        $title = "Presentation";
        return $this->render('project/play.html.twig', [
            'title' => $title,
            'json' => $json
        ]);
    }

    /**
     * @Route("/proj/about")
     */
    public function projAbout(): Response
    {
        $url = "myfile.json";
        $json = file_get_contents($url);
        $title = "About";
        return $this->render('project/about.html.twig', [
            'title' => $title,
            'json' => $json
        ]);
    }


    /**
     * @Route("/proj/reset"),
     * methods={"GET"}
     */
    public function reset(): Response
    {

        return $this->redirectToRoute("highscore_delete");
    }

    /**
     * @Route("/proj/playpoker"),
     * methods={"POST"}
     */
    public function playPoker(Request $request, SessionInterface $session): Response
    {
        $url = "myfile.json";
        $json = file_get_contents($url);
        $title = "Presentation";


        if ($request->request->get("fav_language")) {
            $game = $session->get('Poker');

            $game->setHorisontalCards($session->get('oneCard')[0], $request->request->get("fav_language"));

            $oneCard = $game->takeOneCard();
            $session->set('oneCard', $oneCard);
            $horisontal = $game->getHorisontalCards();

            $pointsHorisental = $game->calculateHorisentalt();
            $pointsVerticalt = $game->calculateVerticalt();

            $game->setTotalPoints($pointsHorisental, $pointsVerticalt);

            $session->set('Poker', $game);

            if (count($game->getHorisontalCards()[1]) + count($game->getHorisontalCards()[2]) + count($game->getHorisontalCards()[3]) + count($game->getHorisontalCards()[4]) + count($game->getHorisontalCards()[5]) == 25) {
                # code...
                return $this->render('project/savePoints.html.twig', [
                    'name'        => $game->getPlayer()->name,
                    'totalPoints' => $game->getTotalPoints(),
                    'json' => $json
                ]);
            }

             return $this->render('project/playpoker.html.twig', [

                'title' => $title,
                'horisontal' => $horisontal,
                'oneCard' =>   $oneCard[0] ,
                'pointsHorisental' =>  $pointsHorisental,
                'pointsVertical' => $pointsVerticalt,
                'totalPoints' => $game->getTotalPoints(),
                'json' => $json

             ]);
        }
        if ($request->request->get("fname")) {
            # code...
            $PlayerName = $request->request->get("fname");
            $game = new \App\Poker\Poker($PlayerName);
            $game->createDeckAndShuffle();
           // print_r($game->getPlayer());
            $game->startSetFiveCards();
            $oneCard = $game->takeOneCard();
           //print_r($oneCard);
            $session->set('oneCard', $oneCard);
           //$game->get_verticalCards();
           // $game->get_verticalCards();
            $horisontal = $game->getHorisontalCards();
            $pointsHorisental = $game->calculateHorisentalt();
            $pointsVerticalt = $game->calculateVerticalt();
            $game->setTotalPoints($pointsHorisental, $pointsVerticalt);
            $session->set('Poker', $game);
            //var_dump($verticalt);
        //    var_dump($horisontal);
            return $this->render('project/playpoker.html.twig', [

                'title' => $title,
                'test' => $request->request->get('fname'),
                'horisontal' => $horisontal,
                'oneCard' =>   $oneCard[0],
                'pointsHorisental' =>  $pointsHorisental,
                'pointsVertical' => $pointsVerticalt,
                'totalPoints' => $game->getTotalPoints(),
                'json' => $json
            ]);
        }
    }
}

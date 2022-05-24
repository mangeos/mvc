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
    public function ProjectStart(): Response
    {
        $title = "Presentation";
        return $this->render('project/base.html.twig', [
            'title' => $title,
        ]);
    }

    /**
     * @Route("/proj/play")
     */
    public function ProjPlay(): Response
    {
        $title = "Presentation";
        return $this->render('project/play.html.twig', [
            'title' => $title,
        ]);
    }

    /**
     * @Route("/proj/about")
     */
    public function ProjAbout(): Response
    {
        $title = "Presentation";
        return $this->render('project/about.html.twig', [
            'title' => $title,
        ]);
    }

    /**
     * @Route("/proj/playpoker"),
     * methods={"POST"}
     */
    public function PlayPoker(Request $request, SessionInterface $session): Response
    { 

        $title = "Presentation";
        if ($request->request->get("fav_language")) {
            # code...
            $game = $session->get('Poker');
           // var_dump($request->request->get("fav_language"));
            $game->set_horisontalCards($session->get('oneCard')[0], $request->request->get("fav_language"));
           // $game->set_horisontalCards($session->get('Poker'), $request->request->get("rad1"));
            
          //  $PlayerName = $game->get_player();
          //$PlayerName = $PlayerName->$name;
          
            $oneCard = $game->take_one_card();
            $session->set('oneCard', $oneCard);
            $horisontal = $game->get_horisontalCards();
            //var_dump($horisontal);
           // var_dump( $game->get_verticalCards());
            $game->calculate_horisentalt();
            
              $session->set('Poker', $game);
             return $this->render('project/playpoker.html.twig', [
                
                'title' => $title,
                'horisontal' => $horisontal,
                'oneCard' =>   $oneCard[0] 
            ]);
        }
        if ($request->request->get("fname")) {
            # code...
            $PlayerName = $request->request->get("fname");
            $game = New \App\Poker\Poker($PlayerName);
            $game->create_deck_and_shuffle();
           // print_r($game->get_player());
            $game->start_set_five_cards();
            $oneCard = $game->take_one_card();
           //print_r($oneCard);
            $session->set('oneCard', $oneCard);
           //$game->get_verticalCards();
           // $game->get_verticalCards();
            $horisontal = $game->get_horisontalCards();
            $session->set('Poker', $game);
            //var_dump($verticalt);
        //    var_dump($horisontal);
            return $this->render('project/playpoker.html.twig', [

                'title' => $title,
                'test' => $request->request->get('fname'),
                'horisontal' => $horisontal,
                'oneCard'=>   $oneCard[0] 
            ]);
        }

        return $this->render('project/playpoker.html.twig', [
            'title' => $title,
            'test' => $request->request->get('fname')
        ]);
    }

}
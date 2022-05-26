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
        $url = "myfile.json";
        $json = file_get_contents($url);
        $json = json_decode($json, TRUE);
        
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
    public function ProjPlay(): Response
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
    public function ProjAbout(): Response
    {
        $url = "myfile.json";
        $json = file_get_contents($url);
        $title = "Presentation";
        return $this->render('project/about.html.twig', [
            'title' => $title,
            'json' => $json
        ]);
    }


    /**
     * @Route("/proj/databasen"),
     * methods={"POST","GET"}
     */
    public function databasen(Request $request): Response
    {

        return $this->redirectToRoute("app_project_projectstart");
    }

    /**
     * @Route("/proj/playpoker"),
     * methods={"POST"}
     */
    public function PlayPoker(Request $request, SessionInterface $session): Response
    { 
        $url = "myfile.json";
        $json = file_get_contents($url);
        $title = "Presentation";

        
        if ($request->request->get("fav_language")) {
            
            $game = $session->get('Poker');

         
            //    if (count($game->get_horisontalCards()) * count($game->get_verticalCards() == 25)) {
                # code...
                
                
                
                //       return $this->render('project/playpoker.html.twig', [
                    //         'title' => $title,
                    //       'namn' => 'namn',
                    //     'totalPoints' => $game->get_total_points()
                    // ]);
                    // }
                    
                    
                    
                    # code...
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
            $pointsHorisental = $game->calculate_horisentalt();
            $pointsVerticalt = $game->calculate_verticalt();
            
            //  print_r( $pointsHorisental);
            $game->set_total_points($pointsHorisental, $pointsVerticalt);
            
            $session->set('Poker', $game);

            if (count($game->get_horisontalCards()[1])+count($game->get_horisontalCards()[2])+count($game->get_horisontalCards()[3])+count($game->get_horisontalCards()[4])+count($game->get_horisontalCards()[5]) == 25) {
                # code...
                return $this->render('project/savePoints.html.twig', [
                    'name'        => $game->get_player()->name,
                    'totalPoints' => $game->get_total_points(),
                    'json' => $json
                ]);
            }

             return $this->render('project/playpoker.html.twig', [
                
                'title' => $title,
                'horisontal' => $horisontal,
                'oneCard' =>   $oneCard[0] ,
                'pointsHorisental' =>  $pointsHorisental,
                'pointsVertical'=> $pointsVerticalt,
                'totalPoints' => $game->get_total_points(),
                'json' => $json

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
            $pointsHorisental = $game->calculate_horisentalt();
            $pointsVerticalt = $game->calculate_verticalt();
            $game->set_total_points($pointsHorisental, $pointsVerticalt);
            $session->set('Poker', $game);
            //var_dump($verticalt);
        //    var_dump($horisontal);
            return $this->render('project/playpoker.html.twig', [

                'title' => $title,
                'test' => $request->request->get('fname'),
                'horisontal' => $horisontal,
                'oneCard'=>   $oneCard[0],
                'pointsHorisental' =>  $pointsHorisental,
                'pointsVertical'=> $pointsVerticalt,
                'totalPoints' => $game->get_total_points(),
                'json' => $json
            ]);
        }
    }

}
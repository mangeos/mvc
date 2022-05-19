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
        if ($request->request->get("fname")) {
            # code...
            $PlayerName = $request->request->get("fname");
            $game = New \App\Poker\Poker($PlayerName);
            $game->create_deck_and_shuffle();
            print_r($game->get_player());

            return $this->render('project/playpoker.html.twig', [
            'title' => $title,
            'test' => $request->request->get('fname')
            ]);
        }

        return $this->render('project/playpoker.html.twig', [
            'title' => $title,
            'test' => $request->request->get('fname')
        ]);
    }

}
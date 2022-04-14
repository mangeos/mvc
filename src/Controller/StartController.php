<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StartController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function present(): Response
    {
        $title = "Presentation";
        return $this->render('presentation/present.html.twig', [
            'title' => $title,
        ]);
    }

    /**
    * @Route("/about")
    */
    public function about(): Response
    {
        $title = "About";
        return $this->render('about/about.html.twig', [
            'title' => $title
        ]);
    }

    /**
    * @Route("/report")
    */
    public function report(): Response
    {
        $title = "Report";
        return $this->render('report/report.html.twig', [
            'title' => $title,
        ]);
    }

      /**
    * @Route("/game/card")
    */
    public function gameCard(): Response
    {
        $title = "Report";
        return $this->render('report/report.html.twig', [
            'title' => $title,
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Highscore;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\HighscoreRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class HighscoreController extends AbstractController
{
    #[Route('/highscore', name: 'app_highscore')]
    public function index(): Response
    {
        return $this->render('highscore/index.html.twig', [
            'controller_name' => 'HighscoreController',
        ]);
    }

    /**
    * @Route("/highscore/create", name="create_highscore")
    */
    public function createhighscore(SessionInterface $session, ManagerRegistry $doctrine, Request $request): Response
    {
        $session->clear();

        $playerName = $request->request->get('playerName');
        $totalPoints = $request->request->get('totalPoints');

        $entityManager = $doctrine->getManager();

        $highscore = new Highscore();
        $highscore->setPlayername($playerName);
        $highscore->setPoints(intval($totalPoints));

        // tell Doctrine you want to (eventually) save the highscore
        // (no queries yet)
        $entityManager->persist($highscore);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        $session->set("id", $highscore->getId());


        return $this->redirectToRoute("highscore_show_all");
    }


    /**
    * @Route("/highscore/show", name="highscore_show_all")
    */
    public function showAllHighscores(HighscoreRepository $HighscoreRepository): Response
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $highscores = $HighscoreRepository->findAll();
        $jsonContent = $serializer->serialize($highscores, 'json');
        //$json = json_encode($highscores);

          // encode array to json

        file_put_contents("myfile.json", $jsonContent); //generate json file
       // return $this->json($highscores);
        return $this->redirectToRoute("app_project_projectstart");
    }


    /**
    * @Route("/highscore/delete", name="highscore_delete")
    */
    public function deleteAll(
        SessionInterface $session,
        ManagerRegistry $doctrine,
        HighscoreRepository $HighscoreRepository
    ): Response {
        $antalHighscores = count($HighscoreRepository->findAll());

        $firstId = intval($session->get("id")) - intval($antalHighscores) + 1;

        $entityManager = $doctrine->getManager();

        for ($i = $firstId; $i <= intval($session->get("id")); $i++) {
            # code...
            $delete = $entityManager->getRepository(Highscore::class)->find($i);

            $entityManager->remove($delete);
            $entityManager->flush();
        }
        $session->clear();
        return $this->redirectToRoute("highscore_show_all");
    }
}

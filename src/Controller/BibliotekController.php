<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Bibliotek;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\BibliotekRepository;

class BibliotekController extends AbstractController
{
    /**
     * @Route("/bibliotek", name="app_bibliotek"),
     * methods = {"GET"}
     */
    public function index(Request $request): Response
    {
        $title = "Bibliotek";
        return $this->render('bibliotek/bibliotek.html.twig', [
            'title' => $title,
        ]);
    }

    /**
     * @Route("/bibliotek/create", name="create_bibliotek"),
     * methods = {"GET", "POST"}
     */
    public function createbibliotek(Request $request, ManagerRegistry $doctrine): Response
    {
        if ($request->request->get('title')) {
                $title = $request->request->get('title');
                $ISBN = $request->request->get('ISBN');
                $forfattare = $request->request->get('forfattare');
                $bild = $request->request->get('bild');

                $entityManager = $doctrine->getManager();

                $bibliotek = new Bibliotek();
                $bibliotek->setTitel($title);
                $bibliotek->setISBN($ISBN);
                $bibliotek->setBild($bild);
                $bibliotek->setFörfattare($forfattare);

                // tell Doctrine you want to (eventually) save the bibliotek
                // (no queries yet)
                $entityManager->persist($bibliotek);

                // actually executes the queries (i.e. the INSERT query)
                $entityManager->flush();

                return $this->redirectToRoute('Bibliotek_show_all');
        }
             $title = "Bibliotek";

              return $this->render('bibliotek/create.html.twig', [
                'title' => $title,
              ]);
    }


    /**
     * @Route("/bibliotek/show/{id}", name="bibliotek_by_id")
    */
    public function showBibliotekById(BibliotekRepository $BibliotekRepository, int $id): Response
    {
        $Bibliotek = $BibliotekRepository->find($id);
        $title = "Bok";
        return $this->render('bibliotek/showbok.html.twig', [
            'title'     => $title,
            'Bibliotek' => $Bibliotek,
        ]);
    }

    /**
    * @Route("/bibliotek/show", name="Bibliotek_show_all")
    */
    public function showAllBibliotek(BibliotekRepository $BibliotekRepository): Response
    {
        $Biblioteks = $BibliotekRepository->findAll();
        $title = "Show All";
        return $this->render('bibliotek/show.html.twig', [
            'title'      => $title,
            'Biblioteks' => $Biblioteks,
        ]);
    }

        /**
     * @Route("/bibliotek/delete/{id}", name="Bibliotek_delete_by_id"),
     * methods = {"GET","POST"}
     */
    public function deleteBibliotekById(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $Bibliotek = $entityManager->getRepository(Bibliotek::class)->find($id);

        if (!$Bibliotek) {
            throw $this->createNotFoundException(
                'No Bibliotek found for id ' . $id
            );
        }

        $entityManager->remove($Bibliotek);
        $entityManager->flush();

        return $this->redirectToRoute('Bibliotek_show_all');
    }

    /**
    * @Route("/bibliotek/update/{id}", name="Bibliotek_update"),
    * methods = {"GET","POST"}
    */
    public function updateBibliotek(Request $request, ManagerRegistry $doctrine, int $id): Response
    {

        if ($request->request->get('title')) {
            $title = $request->request->get('title');
            $ISBN = $request->request->get('ISBN');
            $forfattare = $request->request->get('forfattare');
            $bild = $request->request->get('bild');


            $entityManager = $doctrine->getManager();
            $Bibliotek = $entityManager->getRepository(Bibliotek::class)->find($id);

            if (!$Bibliotek) {
                throw $this->createNotFoundException(
                    'No product found for id ' . $id
                );
            }

            $Bibliotek->setTitel($title);
            $Bibliotek->setISBN($ISBN);
            $Bibliotek->setBild($bild);
            $Bibliotek->setFörfattare($forfattare);

            // tell Doctrine you want to (eventually) save the bibliotek
            // (no queries yet)
            $entityManager->persist($Bibliotek);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();

            return $this->redirectToRoute('Bibliotek_show_all');
        }


        $entityManager = $doctrine->getManager();
        $Bibliotek = $entityManager->getRepository(Bibliotek::class)->find($id);

        return $this->render('bibliotek/update.html.twig', [
          "Bibliotek" => $Bibliotek,
          "title"     => "Redigera"
        ]);
    }
}

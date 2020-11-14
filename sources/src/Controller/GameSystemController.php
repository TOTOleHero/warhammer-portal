<?php

namespace App\Controller;

use App\Entity\GameSystem;
use App\Form\GameSystemType;
use App\Repository\GameSystemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class GameSystemController extends AbstractFOSRestController
{
    /**
     * @Route("/game-system/", name="game_system_index", methods={"GET"})
     */
    public function index(GameSystemRepository $gameSystemRepository): Response
    {
        return $this->render('game_system/index.html.twig', [
            'game_systems' => $gameSystemRepository->findAll(),
        ]);
    }


    /**
     * @Route("/api/game-system/", name="api_game_system_index", methods={"GET"})
     */
    public function apiIndex(GameSystemRepository $gameSystemRepository): Response
    {
        $view = $this->view($gameSystemRepository->findAll(), 200);

        return $this->handleView($view);

    }


    /**
     * @Route("/game-system/new", name="game_system_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $gameSystem = new GameSystem();
        $form = $this->createForm(GameSystemType::class, $gameSystem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($gameSystem);
            $entityManager->flush();

            return $this->redirectToRoute('game_system_index');
        }

        return $this->render('game_system/new.html.twig', [
            'game_system' => $gameSystem,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/game-system/{id}", name="game_system_show", methods={"GET"})
     */
    public function show(GameSystem $gameSystem): Response
    {
        return $this->render('game_system/show.html.twig', [
            'game_system' => $gameSystem,
        ]);

    }


    /**
     * @Route("/api/game-system/{id}", name="api_game_system_show", methods={"GET"})
     */
    public function apiShow(GameSystem $gameSystem): Response
    {
        $view = $this->view($gameSystem, 200);

        return $this->handleView($view);

    }

    /**
     * @Route("/game-system/{id}/edit", name="game_system_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, GameSystem $gameSystem): Response
    {
        $form = $this->createForm(GameSystemType::class, $gameSystem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('game_system_index');
        }

        return $this->render('game_system/edit.html.twig', [
            'game_system' => $gameSystem,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/game-system/{id}", name="game_system_delete", methods={"DELETE"})
     */
    public function delete(Request $request, GameSystem $gameSystem): Response
    {
        if ($this->isCsrfTokenValid('delete'.$gameSystem->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($gameSystem);
            $entityManager->flush();
        }

        return $this->redirectToRoute('game_system_index');
    }
}

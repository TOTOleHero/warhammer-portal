<?php

namespace App\Controller;

use App\Entity\GameSystem;
use App\Form\GameSystemType;
use App\Repository\GameSystemRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameSystemController extends AbstractFOSRestController
{
    /**
     * @Route("/game-system/", name="game_system_index", methods={"GET"})
     */
    public function index(GameSystemRepository $gameSystemRepository, $embedType = false): Response
    {
        $templateBase = 'game_system/';
        $template = 'index.html.twig';
        switch ($embedType) {
            case 'groupListContainer':
                $template = 'list_group.html.twig';
                break;
            case 'dropdownList':
                $template = 'dropdown.html.twig';
                break;
            case false:
                break;
            default:
                return $this->render('embedTypeNotFound.html.twig', [
                    'embedType' => $embedType,
                    'method' => __METHOD__,
                    'class' => __CLASS__,
                ]);
        }

        return $this->render($templateBase.$template, [
            'game_systems' => $gameSystemRepository->findAll(),
        ]);
    }

    /**
     * @Route("/api/game-system/", name="api_game_system_index", methods={"GET"})
     * 
     * @OA\Tag(name="game-system")
     */
    public function apiIndex(GameSystemRepository $gameSystemRepository): Response
    {
        $view = $this->view($gameSystemRepository->findAll(), 200);

        return $this->handleView($view);
    }

    /**
     * @Route("/contribute/game-system/new", name="game_system_new", methods={"GET","POST"})
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
     * 
     * @OA\Tag(name="game-system")
     */
    public function apiShow(GameSystem $gameSystem): Response
    {
        $view = $this->view($gameSystem, 200);

        return $this->handleView($view);
    }

    /**
     * @Route("/contribute/game-system/{id}/edit", name="game_system_edit", methods={"GET","POST"})
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
     * @Route("/contribute/game-system/{id}", name="game_system_delete", methods={"DELETE"})
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

<?php

namespace App\Controller;

use App\Entity\World;
use App\Form\WorldType;
use App\Repository\WorldRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;


class WorldController  extends AbstractFOSRestController
{
    /**
     * @Route("/world", name="world_index", methods={"GET"})
     */
    public function index(WorldRepository $worldRepository): Response
    {
        return $this->render('world/index.html.twig', [
            'worlds' => $worldRepository->findAll(),
        ]);
    }


    /**
     * @Route("/api/world", name="api_world_index", methods={"GET"})
     */
    public function apiIindex(WorldRepository $worldRepository): Response
    {
        $view = $this->view($worldRepository->findAll(), 200);

        return $this->handleView($view);
    }

    /**
     * @Route("/worldnew", name="world_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $world = new World();
        $form = $this->createForm(WorldType::class, $world);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($world);
            $entityManager->flush();

            return $this->redirectToRoute('world_index');
        }

        return $this->render('world/new.html.twig', [
            'world' => $world,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/world{id}", name="world_show", methods={"GET"})
     */
    public function show(World $world): Response
    {
        return $this->render('world/show.html.twig', [
            'world' => $world,
        ]);
    }

    /**
     * @Route("/api/world{id}", name="api_world_show", methods={"GET"})
     */
    public function apiShow(World $world): Response
    {
        $view = $this->view($world, 200);

        return $this->handleView($view);
    }    

    /**
     * @Route("/world{id}/edit", name="world_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, World $world): Response
    {
        $form = $this->createForm(WorldType::class, $world);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('world_index');
        }

        return $this->render('world/edit.html.twig', [
            'world' => $world,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/world{id}", name="world_delete", methods={"DELETE"})
     */
    public function delete(Request $request, World $world): Response
    {
        if ($this->isCsrfTokenValid('delete'.$world->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($world);
            $entityManager->flush();
        }

        return $this->redirectToRoute('world_index');
    }
}

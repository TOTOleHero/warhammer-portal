<?php

namespace App\Controller;

use App\Entity\Nation;
use App\Form\NationType;
use App\Manager\NationManager;
use App\Repository\NationRepository;
use App\Repository\UnitGenericRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NationController extends AbstractFOSRestController
{
    /**
     * @Route("/nation/", name="nation_index", methods={"GET"})
     */
    public function index(NationRepository $nationRepository): Response
    {
        return $this->render('nation/index.html.twig', [
            'nations' => $nationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/api/nation/", name="api_nation_index", methods={"GET"})
     */
    public function apiIndex(NationRepository $nationRepository): Response
    {
        $view = $this->view($nationRepository->findAll(), 200);

        return $this->handleView($view);
    }

    /**
     * @Route("/api/unitGeneric/{unitGenericId}/nation/", name="api_nation_by_unitGeneric", methods={"GET"})
     */
    public function apiGetByUnitGenericId(NationManager $nationManager,$unitGenericId): Response
    {
        $view = $this->view($nationManager->findByUnitGeneric($unitGenericId), 200);

        return $this->handleView($view);
    }


    /**
     * @Route("/nation/new", name="nation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $nation = new Nation();
        $form = $this->createForm(NationType::class, $nation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($nation);
            $entityManager->flush();

            return $this->redirectToRoute('nation_index');
        }

        return $this->render('nation/new.html.twig', [
            'nation' => $nation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/nation/{id}", name="nation_show", methods={"GET"})
     */
    public function show(Nation $nation, UnitGenericRepository $unitGenericRepository): Response
    {
        return $this->render('nation/show.html.twig', [
            'unitGenerics' => $unitGenericRepository->findByNation($nation),
            'nation' => $nation,
        ]);
    }

    /**
     * @Route("/api/nation/{id}", name="api_nation_show", methods={"GET"})
     */
    public function apiShow(Nation $nation): Response
    {
        $view = $this->view($nation, 200);

        return $this->handleView($view);
    }

    /**
     * @Route("/nation/{id}/edit", name="nation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Nation $nation): Response
    {
        $form = $this->createForm(NationType::class, $nation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('nation_index');
        }

        return $this->render('nation/edit.html.twig', [
            'nation' => $nation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/nation/{id}", name="nation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Nation $nation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$nation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($nation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('nation_index');
    }
}

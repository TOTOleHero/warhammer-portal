<?php

namespace App\Controller;

use App\Entity\UnitGeneric;
use App\Form\UnitGenericType;
use App\Manager\UnitGenericManager;
use App\Repository\UnitGenericRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

class UnitGenericController extends AbstractFOSRestController
{
    /**
     * @Route("/unitGeneric/", name="unitGeneric_index", methods={"GET"})
     */
    public function index(UnitGenericRepository $unitGenericRepository): Response
    {
        return $this->render('unitGeneric/index.html.twig', [
            'unitGenerics' => $unitGenericRepository->findAll(),
        ]);
    }

    /**
     * @Route("/api/unitGeneric/", name="api_unitGeneric_index", methods={"GET"})
     * 
     * @OA\Tag(name="unitGeneric")
     */
    public function apiIndex(UnitGenericRepository $unitGenericRepository): Response
    {
        $view = $this->view($unitGenericRepository->findAll(), 200);

        return $this->handleView($view);
    }

    /**
     * @Route("/api/nation/{nationId}/unitGeneric/", name="api_unitGeneric_by_nation", methods={"GET"})
     * 
     * @OA\Tag(name="nation")
     */
    public function apigetAllByNationId(UnitGenericManager $unitGenericManager,$nationId): Response
    {
        $view = $this->view($unitGenericManager->findByNationId($nationId), 200);

        return $this->handleView($view);
    }    

    /**
     * @Route("/contribute/unitGeneric/new", name="unitGeneric_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $unitGeneric = new UnitGeneric();
        $form = $this->createForm(UnitGenericType::class, $unitGeneric);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($unitGeneric);
            $entityManager->flush();

            return $this->redirectToRoute('unitGeneric_index');
        }

        return $this->render('unitGeneric/new.html.twig', [
            'unitGeneric' => $unitGeneric,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/unitGeneric/{id}", name="unitGeneric_show", methods={"GET"})
     */
    public function show(UnitGeneric $unitGeneric): Response
    {
        return $this->render('unitGeneric/show.html.twig', [
            'unitGeneric' => $unitGeneric,
        ]);
    }

    /**
     * @Route("/api/unitGeneric/{id}", name="api_unitGeneric_show", methods={"GET"})
     * 
     * @OA\Tag(name="unitGeneric")
     */
    public function apiShow(UnitGeneric $unitGeneric): Response
    {
        $view = $this->view($unitGeneric, 200);

        return $this->handleView($view);
    }

    /**
     * @Route("/contribute/unitGeneric/{id}/edit", name="unitGeneric_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UnitGeneric $unitGeneric): Response
    {
        $form = $this->createForm(UnitGenericType::class, $unitGeneric);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('unitGeneric_index');
        }

        return $this->render('unitGeneric/edit.html.twig', [
            'unitGeneric' => $unitGeneric,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/contribute/unitGeneric/{id}", name="unitGeneric_delete", methods={"DELETE"})
     */
    public function delete(Request $request, UnitGeneric $unitGeneric): Response
    {
        if ($this->isCsrfTokenValid('delete'.$unitGeneric->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($unitGeneric);
            $entityManager->flush();
        }

        return $this->redirectToRoute('unitGeneric_index');
    }
}

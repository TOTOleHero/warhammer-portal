<?php

namespace App\Controller;

use App\Entity\UnitGameSystem;
use App\Form\UnitGameSystemType;
use App\Repository\UnitGameSystemRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UnitGameSystemController extends AbstractFOSRestController
{
    /**
     * @Route("/unitGameSystem/", name="unitGameSystem_index", methods={"GET"})
     */
    public function index(UnitGameSystemRepository $unitGameSystemRepository): Response
    {
        return $this->render('unitGameSystem/index.html.twig', [
            'unitGameSystems' => $unitGameSystemRepository->findAll(),
        ]);
    }

    /**
     * @Route("/api/unitGameSystem/", name="api_unitGameSystem_index", methods={"GET"})
     * @OA\Response(
     *     response=200,
     *     description="All UnitGameSystem",
     *     @OA\JsonContent(
     *         type="array",
     *         @OA\Items(ref=@Model(type=UnitGameSystem::class))
     *     )
     * 
     * )
     * @OA\Tag(name="unti")
     */
    public function apiIndex(UnitGameSystemRepository $unitGameSystemRepository): Response
    {
        $view = $this->view($unitGameSystemRepository->findAll(), 200);

        return $this->handleView($view);
    }

    /**
     * @Route("/api/unitGeneric/{unitGenericId}/unitGameSystem/", name="api_unitGameSystem_by_unitGeneric", methods={"GET"})
     * @OA\Response(
     *     response=200,
     *     description="All UnitGameSystem",
     *     @OA\JsonContent(
     *         type="array",
     *         @OA\Items(ref=@Model(type=UnitGameSystem::class))
     *     )
     * )
     * @OA\Tag(name="unti")
     */
    public function apiGetAllByUnitGenericId(UnitGameSystemRepository $unitGameSystemRepository,$unitGenericId): Response
    {
        $view = $this->view($unitGameSystemRepository->findByUnitGeneric($unitGenericId), 200);

        return $this->handleView($view);
    }    

    /**
     * @Route("/unitGameSystem/new", name="unitGameSystem_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $unitGameSystem = new UnitGameSystem();
        $form = $this->createForm(UnitGameSystemType::class, $unitGameSystem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($unitGameSystem);
            $entityManager->flush();

            return $this->redirectToRoute('unitGameSystem_index');
        }

        return $this->render('unitGameSystem/new.html.twig', [
            'unitGameSystem' => $unitGameSystem,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/unitGameSystem/{id}", name="unitGameSystem_show", methods={"GET"})
     * @OA\Response(
     *     response=200,
     *     description="One UnitGameSystem",
     *     @OA\JsonContent(
     *         type="array",
     *         @OA\Items(ref=@Model(type=UnitGameSystem::class))
     *     )
     * )
     * @OA\Tag(name="unit")
     */
    public function show(UnitGameSystem $unitGameSystem): Response
    {
        return $this->render('unitGameSystem/show.html.twig', [
            'unitGameSystem' => $unitGameSystem,
        ]);
    }

    /**
     * @Route("/api/unitGameSystem/{id}", name="api_unitGameSystem_show", methods={"GET"})
     */
    public function apiShow(UnitGameSystem $unitGameSystem): Response
    {
        $view = $this->view($unitGameSystem, 200);

        return $this->handleView($view);
    }

    /**
     * @Route("/unitGameSystem/{id}/edit", name="unitGameSystem_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UnitGameSystem $unitGameSystem): Response
    {
        $form = $this->createForm(UnitGameSystemType::class, $unitGameSystem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('unitGameSystem_index');
        }

        return $this->render('unitGameSystem/edit.html.twig', [
            'unitGameSystem' => $unitGameSystem,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/unitGameSystem/{id}", name="unitGameSystem_delete", methods={"DELETE"})
     */
    public function delete(Request $request, UnitGameSystem $unitGameSystem): Response
    {
        if ($this->isCsrfTokenValid('delete'.$unitGameSystem->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($unitGameSystem);
            $entityManager->flush();
        }

        return $this->redirectToRoute('unitGameSystem_index');
    }
}

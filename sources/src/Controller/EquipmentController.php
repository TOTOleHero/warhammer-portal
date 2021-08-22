<?php

namespace App\Controller;

use App\Entity\Equipment;
use App\Form\EquipmentType;
use App\Repository\EquipmentRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EquipmentController extends AbstractFOSRestController
{
    /**
     * @Route("/equipment/", name="equipment_index", methods={"GET"})
     */
    public function index(EquipmentRepository $equipmentRepository): Response
    {
        return $this->render('equipment/index.html.twig', [
            'equipment' => $equipmentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/api/equipment/", name="api_equipment_index", methods={"GET"})
     * @OA\Response(
     *     response=200,
     *     description="All Equipment",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Equipment::class))
     *     )
     * )
     * @OA\Tag(name="equipment")
     */
    public function apiIndex(EquipmentRepository $equipmentRepository): Response
    {
        $view = $this->view($equipmentRepository->findAll(), 200);

        return $this->handleView($view);
    }

    /**
     * @Route("/contribute/equipment/new", name="equipment_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $equipment = new Equipment();
        $form = $this->createForm(EquipmentType::class, $equipment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($equipment);
            $entityManager->flush();

            return $this->redirectToRoute('equipment_index');
        }

        return $this->render('equipment/new.html.twig', [
            'equipment' => $equipment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/equipment/{id}", name="equipment_show", methods={"GET"})
     */
    public function show(Equipment $equipment): Response
    {
        return $this->render('equipment/show.html.twig', [
            'equipment' => $equipment,
        ]);
    }

    /**
     * @Route("/api/equipment/{id}", name="api_equipment_show", methods={"GET"})
     * @OA\Response(
     *     response=200,
     *     description="One Equipment",
     *     @Model(type=Equipment::class)
     * )
     * @OA\Tag(name="equipment")
     */
    public function apiShow(Equipment $equipment): Response
    {
        $view = $this->view($equipment, 200);

        return $this->handleView($view);
    }

    /**
     * @Route("/contribute/equipment/{id}/edit", name="equipment_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Equipment $equipment): Response
    {
        $form = $this->createForm(EquipmentType::class, $equipment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('equipment_index');
        }

        return $this->render('equipment/edit.html.twig', [
            'equipment' => $equipment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/contribute/equipment/{id}", name="equipment_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Equipment $equipment): Response
    {
        if ($this->isCsrfTokenValid('delete'.$equipment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($equipment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('equipment_index');
    }
}

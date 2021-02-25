<?php

namespace App\Controller;

use App\Entity\EquipmentType;
use App\Form\EquipmentTypeType;
use App\Repository\EquipmentTypeRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EquipmentTypeController extends AbstractFOSRestController
{
    /**
     * @Route("/equipmentType/", name="equipment_type_index", methods={"GET"})
     */
    public function index(EquipmentTypeRepository $equipmentTypeRepository): Response
    {
        return $this->render('equipment_type/index.html.twig', [
            'equipment_types' => $equipmentTypeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/api/equipmentType/", name="api_equipment_type_index", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="All EquipmentType",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=EquipmentType::class))
     *     )
     * )
     * @SWG\Tag(name="equipment")
     */
    public function apiIndex(EquipmentTypeRepository $equipmentTypeRepository): Response
    {
        $view = $this->view($equipmentTypeRepository->findAll(), 200);

        return $this->handleView($view);
    }

    /**
     * @Route("/equipmentType/new", name="equipment_type_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $equipmentType = new EquipmentType();
        $form = $this->createForm(EquipmentTypeType::class, $equipmentType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($equipmentType);
            $entityManager->flush();

            return $this->redirectToRoute('equipment_type_index');
        }

        return $this->render('equipment_type/new.html.twig', [
            'equipment_type' => $equipmentType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/equipmentType/{id}", name="equipment_type_show", methods={"GET"})
     */
    public function show(EquipmentType $equipmentType): Response
    {
        return $this->render('equipment_type/show.html.twig', [
            'equipment_type' => $equipmentType,
        ]);
    }

    /**
     * @Route("/api/equipmentType/{id}", name="api_equipment_type_show", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="One EquipmentType",
     *     @SWG\Schema(
     *         @Model(type=EquipmentType::class)
     *     )
     * )
     * @SWG\Tag(name="equipment")
     */
    public function apiShow(EquipmentType $equipmentType): Response
    {
        $view = $this->view($equipmentType, 200);

        return $this->handleView($view);
    }

    /**
     * @Route("/equipmentType/{id}/edit", name="equipment_type_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EquipmentType $equipmentType): Response
    {
        $form = $this->createForm(EquipmentTypeType::class, $equipmentType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('equipment_type_index');
        }

        return $this->render('equipment_type/edit.html.twig', [
            'equipment_type' => $equipmentType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/equipmentType/{id}", name="equipment_type_delete", methods={"DELETE"})
     */
    public function delete(Request $request, EquipmentType $equipmentType): Response
    {
        if ($this->isCsrfTokenValid('delete'.$equipmentType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($equipmentType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('equipment_type_index');
    }
}

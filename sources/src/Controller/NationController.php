<?php

namespace App\Controller;

use App\Entity\Nation;
use App\Form\NationType;
use App\Manager\NationManager;
use App\Manager\UnitGenericManager;
use App\Repository\NationRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NationController extends AbstractFOSRestController
{
    /**
     * @Route("/nation/", name="nation_index", methods={"GET"})
     */
    public function index(NationRepository $nationRepository, $embedType = false): Response
    {
        $templateBase = 'nation/';
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
            'nations' => $nationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/api/nation/", name="api_nation_index", methods={"GET"})
     *
     * @OA\Tag(name="nation")
     */
    public function apiIndex(NationRepository $nationRepository): Response
    {
        $view = $this->view($nationRepository->findAll(), 200);

        return $this->handleView($view);
    }

    /**
     * @Route("/api/unitGeneric/{unitGenericId}/nation/", name="api_nation_by_unitGeneric", methods={"GET"})
     *
     * @OA\Tag(name="unitGeneric")
     */
    public function apiGetByUnitGenericId(NationManager $nationManager, $unitGenericId): Response
    {
        $view = $this->view($nationManager->findByUnitGeneric($unitGenericId), 200);

        return $this->handleView($view);
    }

    /**
     * @Route("/contribute/nation/new", name="nation_new", methods={"GET","POST"})
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
     * @Route("/nation/{id}/gameSystem/{gameSystem}", name="nation_gameSystem_show", methods={"GET"})
     */
    public function show(Nation $nation, $gameSystem = null, UnitGenericManager $unitGenericManager): Response
    {
        return $this->render('nation/show.html.twig', [
            'unitGenerics' => $unitGenericManager->findByNationAndGameSystem($nation, $gameSystem),
            'nation' => $nation,
        ]);
    }

    /**
     * @Route("/api/nation/{id}", name="api_nation_show", methods={"GET"})
     *
     * @OA\Tag(name="nation")
     */
    public function apiShow(Nation $nation): Response
    {
        $view = $this->view($nation, 200);

        return $this->handleView($view);
    }

    /**
     * @Route("/contribute/nation/{id}/edit", name="nation_edit", methods={"GET","POST"})
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
     * @Route("/contribute/nation/{id}", name="nation_delete", methods={"DELETE"})
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

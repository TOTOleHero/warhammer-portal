<?php

namespace App\Controller;

use App\Entity\Race;
use App\Entity\Unit;
use App\Form\RaceType;
use App\Repository\RaceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;

class RaceController extends AbstractFOSRestController
{
    /**
     * @Route("/race/", name="race_index", methods={"GET"})
     */
    public function index(RaceRepository $raceRepository,Request $request,$embedType = false): Response
    {
        $templateBase = 'race/';
        $template = 'index.html.twig';  
        switch($embedType)
        {
            case 'groupListContainer' :
                $template ='list_group.html.twig';
                break;  
            case 'dropdownList' :
                $template ='dropdown.html.twig';
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
            'races' => $raceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/api/race/", name="api_race_index", methods={"GET"})
     */
    public function apiIndex(RaceRepository $raceRepository): Response
    {
        $view = $this->view($raceRepository->findAll(), 200);

        return $this->handleView($view);
    }


    /**
     * @Route("/race/new", name="race_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $race = new Race();
        $form = $this->createForm(RaceType::class, $race);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($race);
            $entityManager->flush();

            return $this->redirectToRoute('race_index');
        }

        return $this->render('race/new.html.twig', [
            'race' => $race,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/race/{id}", name="race_show", methods={"GET"})
     */
    public function show(Race $race): Response
    {
        $unitRepository = $this->get('doctrine')->getRepository(Unit::class);
        return $this->render('race/show.html.twig', [
            'race' => $race,
            'units' => $unitRepository->findByRace($race)
        ]);
    }

    /**
     * @Route("/api/race/{id}", name="api_race_show", methods={"GET"})
     */
    public function apiShow(Race $race): Response
    {
        $view = $this->view($race, 200);

        return $this->handleView($view);
    }

    /**
     * @Route("/race/{id}/edit", name="race_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Race $race): Response
    {
        $form = $this->createForm(RaceType::class, $race);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('race_index');
        }

        return $this->render('race/edit.html.twig', [
            'race' => $race,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/race/{id}", name="race_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Race $race): Response
    {
        if ($this->isCsrfTokenValid('delete'.$race->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($race);
            $entityManager->flush();
        }

        return $this->redirectToRoute('race_index');
    }
}

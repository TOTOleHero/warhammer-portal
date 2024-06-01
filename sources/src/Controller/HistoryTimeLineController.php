<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HistoryTimeLineController extends AbstractFOSRestController
{
    /**
     * @Route("/timeline/", name="timeline_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('timeline/index.html.twig', [
            'timeLine' => [],
        ]);
    }
}

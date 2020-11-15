<?php

namespace App\Controller;

use App\Entity\ProfileWFB9;
use App\Form\ProfileWFB9Type;
use App\Repository\ProfileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ProfileWFB9Controller extends AbstractController
{
    /**
     * @Route("/profileWFB9/", name="profile_wfb9_index", methods={"GET"})
     */
    public function index(ProfileRepository $profileRepository): Response
    {
        return $this->render('profile_wfb9/index.html.twig', [
            'profile_wfb9s' => $profileRepository->findAll(),
        ]);
    }

    /**
     * @Route("/profileWFB9/new", name="profile_wfb9_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $profileWFB9 = new ProfileWFB9();
        $form = $this->createForm(ProfileWFB9Type::class, $profileWFB9);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($profileWFB9);
            $entityManager->flush();

            return $this->redirectToRoute('profile_wfb9_index');
        }

        return $this->render('profile_wfb9/new.html.twig', [
            'profile_wfb9' => $profileWFB9,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/profileWFB9/{id}", name="profile_wfb9_show", methods={"GET"})
     */
    public function show(ProfileWFB9 $profileWFB9): Response
    {
        return $this->render('profile_wfb9/show.html.twig', [
            'profile_wfb9' => $profileWFB9,
        ]);
    }

    /**
     * @Route("/profileWFB9/{id}/edit", name="profile_wfb9_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ProfileWFB9 $profileWFB9): Response
    {
        $form = $this->createForm(ProfileWFB9Type::class, $profileWFB9);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('profile_wfb9_index');
        }

        return $this->render('profile_wfb9/edit.html.twig', [
            'profile_wfb9' => $profileWFB9,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/profileWFB9/{id}", name="profile_wfb9_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ProfileWFB9 $profileWFB9): Response
    {
        if ($this->isCsrfTokenValid('delete'.$profileWFB9->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($profileWFB9);
            $entityManager->flush();
        }

        return $this->redirectToRoute('profile_wfb9_index');
    }
}

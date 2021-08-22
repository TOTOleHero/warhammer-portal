<?php

namespace App\Controller;

use App\Entity\ProfileAOS4;
use App\Form\ProfileAOS4Type;
use App\Repository\ProfileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

class ProfileAOS4Controller extends AbstractController
{
    /**
     * @Route("/profileAOS4/", name="profile_aos4_index", methods={"GET"})
     */
    public function index(ProfileRepository $profileRepository): Response
    {
        return $this->render('profile_aos4/index.html.twig', [
            'profile_aos4s' => $profileRepository->findAll(),
        ]);
    }

    /**
     * @Route("/contribute/profileAOS4/new", name="profile_aos4_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $profileAOS4 = new ProfileAOS4();
        $form = $this->createForm(ProfileAOS4Type::class, $profileAOS4);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($profileAOS4);
            $entityManager->flush();

            return $this->redirectToRoute('profile_aos4_index');
        }

        return $this->render('profile_aos4/new.html.twig', [
            'profile_aos4' => $profileAOS4,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/profileAOS4/{id}", name="profile_aos4_show", methods={"GET"})
     */
    public function show(ProfileAOS4 $profileAOS4): Response
    {
        return $this->render('profile_aos4/show.html.twig', [
            'profile_aos4' => $profileAOS4,
        ]);
    }

    /**
     * @Route("/contribute/profileAOS4/{id}/edit", name="profile_aos4_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ProfileAOS4 $profileAOS4): Response
    {
        $form = $this->createForm(ProfileAOS4Type::class, $profileAOS4);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('profile_aos4_index');
        }

        return $this->render('profile_aos4/edit.html.twig', [
            'profile_aos4' => $profileAOS4,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/contribute/profileAOS4/{id}", name="profile_aos4_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ProfileAOS4 $profileAOS4): Response
    {
        if ($this->isCsrfTokenValid('delete'.$profileAOS4->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($profileAOS4);
            $entityManager->flush();
        }

        return $this->redirectToRoute('profile_aos4_index');
    }
}

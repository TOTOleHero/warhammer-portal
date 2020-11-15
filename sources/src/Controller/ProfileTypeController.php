<?php

namespace App\Controller;

use App\Entity\ProfileType;
use App\Form\ProfileTypeType;
use App\Repository\ProfileTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ProfileTypeController extends AbstractController
{
    /**
     * @Route("/profileType/", name="profile_type_index", methods={"GET"})
     */
    public function index(ProfileTypeRepository $profileTypeRepository): Response
    {
        return $this->render('profile_type/index.html.twig', [
            'profile_types' => $profileTypeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/profileType/new", name="profile_type_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $profileType = new ProfileType();
        $form = $this->createForm(ProfileTypeType::class, $profileType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($profileType);
            $entityManager->flush();

            return $this->redirectToRoute('profile_type_index');
        }

        return $this->render('profile_type/new.html.twig', [
            'profile_type' => $profileType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/profileType/{id}", name="profile_type_show", methods={"GET"})
     */
    public function show(ProfileType $profileType): Response
    {
        return $this->render('profile_type/show.html.twig', [
            'profile_type' => $profileType,
        ]);
    }

    /**
     * @Route("/profileType/{id}/edit", name="profile_type_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ProfileType $profileType): Response
    {
        $form = $this->createForm(ProfileTypeType::class, $profileType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('profile_type_index');
        }

        return $this->render('profile_type/edit.html.twig', [
            'profile_type' => $profileType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/profileType/{id}", name="profile_type_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ProfileType $profileType): Response
    {
        if ($this->isCsrfTokenValid('delete'.$profileType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($profileType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('profile_type_index');
    }
}

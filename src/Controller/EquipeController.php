<?php

namespace App\Controller;

use App\Entity\Equipe;
use App\Form\EquipeType;
use App\Repository\EquipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/equipe")
 */
class EquipeController extends AbstractController
{
    /**
     * @Route("/", name="equipe_index", methods={"GET"})
     */
    public function index(EquipeRepository $equipeRepository): Response
    {
        return $this->render('base.html.twig', [
            'equipes' => $equipeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="equipe_new", methods={"GET","POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $equipe = new Equipe();
        $equipeform = $this->createForm(EquipeType::class, $equipe);
        $equipeform->handleRequest($request);

        if ($equipeform->isSubmitted() && $equipeform->isValid()) {
            //$entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($equipe);
            $entityManager->flush();

            //return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/{id}", name="equipe_show", methods={"GET"})
     */
    public function show(Equipe $equipe): Response
    {
        return $this->render('equipe/show.html.twig', [
            'equipe' => $equipe,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="equipe_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Equipe $equipe): Response
    {
        $form = $this->createForm(EquipeType::class, $equipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('equipe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('base.html.twig', [
            'equipe' => $equipe,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="equipe_delete", methods={"POST"})
     */
    public function delete(Request $request, Equipe $equipe): Response
    {
        if ($this->isCsrfTokenValid('delete'.$equipe->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($equipe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    }
}

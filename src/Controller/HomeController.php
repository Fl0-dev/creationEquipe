<?php

namespace App\Controller;

use App\Entity\Equipe;
use App\Entity\Personne;
use App\Form\EquipeType;
use App\Form\PersonneType;
use App\Repository\EquipeRepository;
use App\Repository\PersonneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function home(
        EquipeRepository $equipeRepository,
        PersonneRepository $personneRepository
    ): Response
    {
        //affichage du formulaire équipe pour traitement
        $equipe = new Equipe();
        $equipeform = $this->createForm(EquipeType::class, $equipe);
        // sans requête
        //$Equipeform->handleRequest($request);
        //la même pour personne
        $personne = new Personne();
        $personneform = $this->createForm(PersonneType::class, $personne);


        return $this->render('base.html.twig', [
            'equipes' => $equipeRepository->findAll(),
            'personnes' => $personneRepository->findAll(),
            'equipeform'=> $equipeform->createView(),
            'personneform'=> $personneform->createView(),
        ]);
    }
}

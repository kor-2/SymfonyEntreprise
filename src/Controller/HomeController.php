<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Entity\Entreprise;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $entreprises = $doctrine->getRepository(Entreprise::class)->findAll();
        $employes = $doctrine->getRepository(Employe::class)->findAll();

        return $this->render('home/index.html.twig', [
            'name' => 'Application Entreprise / Employés',
            'entreprises' => $entreprises,
            'employes' => $employes,
        ]);
    }
}

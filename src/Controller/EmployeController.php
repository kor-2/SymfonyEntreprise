<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Form\EmployeType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class EmployeController extends AbstractController
{
    /**
     * @Route("/employe", name="app_employe")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $employes = $doctrine->getRepository(Employe::class)->findBy([], ['nom' => 'ASC']);

        return $this->render('employe/index.html.twig', [
            'employes' => $employes,
        ]);
    }

    /**
     * @Route("/employe/add", name="add_employe")
     * @Route("/employe/update/{id}", name="update_employe")
     */
    public function add(ManagerRegistry $doctrine, Employe $employe = null, Request $request, SluggerInterface $slugger): Response
    {
        if (!$employe) {
            $employe = new Employe();
        }
        /**
         * Gestion formulaire ajout d'employé.
         */
        $entityManager = $doctrine->getManager();
        $form = $this->createForm(EmployeType::class, $employe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employe = $form->getData();

            /*
            * upload image.
            */
            $uploads = $form->get('image')->getData();

            if ($uploads) {
                $ogFilename = pathinfo($uploads->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($ogFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$uploads->guessExtension();

                try {
                    $uploads->move(
                        $this->getParameter('upload_image'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    throw $e->getMessage($newFilename);
                }
                $employe->setImage($newFilename);
            }

            /* fin upload image*/
            $entityManager->persist($employe);
            $entityManager->flush();
            /* fin formulaire d'ajout */

            return $this->redirectToRoute('app_employe');
        }

        return $this->render('employe/add.html.twig', [
            'addEmploye' => $form->createView(),
            'editMode' => $employe->getId(),
        ]);
    }

    /**
     * @Route("/employe/delete/{id}", name="del_employe")
     */
    public function delete(ManagerRegistry $doctrine, Employe $employe)
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($employe);
        $entityManager->flush();

        return $this->redirectToRoute('app_employe');
    }

    /**
     * @Route("/employe/{id}", name="show_employe")
     */
    public function show(Employe $employe): Response
    {
        return $this->render('employe/show.html.twig', [
            'employe' => $employe,
        ]);
    }
}

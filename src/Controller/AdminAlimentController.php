<?php

namespace App\Controller;

use App\Entity\Aliment;
use App\Form\AlimentType;
use App\Repository\AlimentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminAlimentController extends AbstractController
{
    /**
     * @Route("/admin/aliments", name="admin_aliments")
     */
    public function adminAliments(AlimentRepository $alimentRepository): Response
    {
        $aliments = $alimentRepository->findAll();
        return $this->render('admin_aliment/adminAliments.html.twig', [
            'aliments' => $aliments,
        ]);
    }

    /**
     * @Route("/admin/aliment/creation", name="admin_aliments_creation")
     * @Route("/admin/aliment/{id}", name="admin_aliments_modification", methods="GET|POST")
     */
    public function ajoutEtModification(Aliment $aliment = null, Request $request, EntityManagerInterface $manager): Response
    {
        if(!$aliment){
            $aliment = new Aliment();
        }
        $form = $this->createForm(AlimentType::class, $aliment);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $modif = $aliment->getId() !==null;
            $manager->persist($aliment);
            $manager->flush();
            $this->addFlash("success", ($modif) ? "La modification a été effectuée." : "L'ajout a été effectué");
            return $this->redirectToRoute("admin_aliments");
        }

        return $this->render('admin_aliment/modifEtAjoutAliments.html.twig',[
            "aliment" => $aliment,
            "form" => $form->createView(),
            "isModification" =>$aliment->getId() !==null
        ] );
    }

    /**
     * @Route("/admin/aliments/{id}", name="admin_aliments_suppression", methods="delete")
     */
    public function suppresion(Aliment $aliment, EntityManagerInterface $entityManagerInterface, Request $request): Response
    {
        if($this->isCsrfTokenValid("SUP" . $aliment->getId(), $request->get('_token'))){
            $entityManagerInterface->remove($aliment);
            $entityManagerInterface->flush();
            $this->addFlash("success", "La suppression a été effectuée.");
            return $this->redirectToRoute("admin_aliments");
        }
    }
 
}

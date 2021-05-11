<?php

namespace App\Controller;

use App\Entity\Type;
use App\Form\TypeType;
use App\Repository\TypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminTypeController extends AbstractController
{
    /**
     * @Route("/admin/type", name="admin_type")
     */
    public function adminType(TypeRepository $typeRepository): Response
    {
        $types = $typeRepository->findAll();
        return $this->render('admin_type/adminType.html.twig', [
            'types' => $types,
        ]);
    }

     /**
     * @Route("/admin/type/creation ", name="admin_type_ajout")
     * @Route("/admin/type/{id} ", name="admin_type_modif", methods="GET|POST") 
     */
    public function AjoutModifType(Type $type = null, Request $request, EntityManagerInterface $manager): Response
    {
        if(!$type){
            $type = new Type();
        }
        $form = $this->createForm(TypeType::class, $type);
        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $modif = $type->getId() !==null;
            $manager->persist($type);
            $manager->flush();
            $this->addFlash("success", ($modif) ? "La modification a été effectée." : "L'ajoute a été effectué");
            return $this->redirectToRoute("admin_type");

        }
        return $this->render('admin_type/modifEtAjoutTypes.html.twig', [
            "type" => $type,
            "form" => $form->createView(),
            "isModification" =>$type->getId() !==null
        ]);
    }

    /**
     * @Route("/admin/type/{id}", name="admin_types_suppression", methods="delete")
     */
    public function suppression(Type $type, EntityManagerInterface $entityManagerInterface, Request $request): Response
    {
        if($this->isCsrfTokenValid("SUP" . $type->getId(), $request->get('_token'))){
            $entityManagerInterface->remove($type);
            $entityManagerInterface->flush();
            $this->addFlash("success", "La suppression a été effectuée.");
            return $this->redirectToRoute("admin_type");
        }
    }
}

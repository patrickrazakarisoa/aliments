<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\AlimentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AlimentController extends AbstractController
{
    /**
     * @Route("/", name="aliments")
     */
    public function index(AlimentRepository $alimentRepository): Response
    {
        $aliments = $alimentRepository->findAll();
        return $this->render('aliment/aliments.html.twig', [
            'aliments' => $aliments,
            'isCalorie' => false,
            'isGlucide' => false,


        ]);
    }

    /**
     * @Route("/aliments/calorie/{calorie} ", name="alimentParCalorie")
     */
    public function alimentMoinsCaloriques(AlimentRepository $alimentRepository, $calorie): Response
    {
        $aliments = $alimentRepository->getAlimentParNbPropriete('calorie', '<', $calorie);
        return $this->render('aliment/aliments.html.twig', [
            'aliments' => $aliments,
            'isCalorie' => true,
            'isGlucide' => false,

        ]);
    }

     /**
     * @Route("/aliments/glucide/{glucide} ", name="alimentParGlucide")
     */
    public function alimentMoinsGlucides(AlimentRepository $alimentRepository, $glucide): Response
    {
        $aliments = $alimentRepository->getAlimentParNbPropriete('glucide', '>', $glucide);
        return $this->render('aliment/aliments.html.twig', [
            'aliments' => $aliments,
            'isGlucide' => true,
            'isCalorie' => false

        ]);
    }
}

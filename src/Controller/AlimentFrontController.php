<?php

namespace App\Controller;

use App\Repository\AlimentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AlimentFrontController extends AbstractController
{

    /**
     * @Route("/stat", name="aliment_statiii", methods={"GET","POST"})
     */
    public function Stat(AlimentRepository $alimentRepository): Response
    {
        $x = json_encode($alimentRepository->getLibelle());
        $x = str_replace('{"libelle":','',$x);
        $x = str_replace('},{"libelle":','',$x);
        $labels = str_replace('}','',$x);

        $y = json_encode($alimentRepository->getCalorie());
        $y = str_replace('{"calorie":','',$y);
        $y = str_replace('},{"calorie":','',$y);
        $datas = str_replace('}','',$y);
        //$datas = $studentRepository->getIds();
        return $this->render('aliment_front/stat.html.twig', [
            'labels' => $labels,'datas' => $datas,
        ]);
    }

    /**
     * @Route("/aliments/front", name="aliment_front")
     */
    public function index(AlimentRepository $alimentRepository): Response
    {
        $aliments = $alimentRepository->findAll();
        return $this->render('aliment_front/index.html.twig', ['aliments' => $aliments]);

    }
//    /**
//     * @Route("/{idAliment}", name="alimentfront_showdd", methods={"GET"})
//     */
//    public function showaf(Aliment $aliment): Response
//    {
//        return $this->render('aliment_front/showAF.html.twig', [
//            'aliment' => $aliment,
//        ]);
//    }
}

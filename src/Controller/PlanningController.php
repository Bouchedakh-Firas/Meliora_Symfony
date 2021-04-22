<?php

namespace App\Controller;

use App\Entity\ListeTaches;
use App\Entity\Planning;
use App\Entity\Tache;
use App\Form\PlanningType;
use App\Form\TacheType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlanningController extends AbstractController
{
    /**
     * @Route("/pp", name="planning")
     */
    public function index(): Response
    {
        return $this->render('planning/index.html.twig', [
            'controller_name' => 'PlanningController',
        ]);
        
    }

    /**
     * @Route("/planning", name="AjouterPlanning")
     */
    public function AjouterPlan(Request $request) {
        $plan = new Planning();
        $form = $this->createForm(PlanningType::class, $plan);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
             $plan = $form->getData();
             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($plan);
             $entityManager->flush();
            $id = $plan->getId();
            # $p = new Planning();
             #$repo = $this->getDoctrine()->getRepository(Planning::class);
             #$p = $repo->find($plan);
            # $id = $p->getId();

             return $this->redirectToRoute('AjouterTachePlanning', ['id' => $id]);
        }
 
        return $this->render('Planning/index.html.twig', [
         'form' => $form->createView(),
     ]);
 
 
 
 
     }

       /**
     * @Route("/planning/tache{id}", name="AjouterTachePlanning")
     */
    public function Ajoutertahce(Request $request, int $id) {
        $repo = $this->getDoctrine()->getRepository(Planning::class);
        $plan = $repo->find($id);
        
        $tache = new Tache();
        $form = $this->createForm(TacheType::class, $tache);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
             $tache = $form->getData();
             $type = $tache->getTypeTache();
             if($type =="video"){
                

             }
             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($tache);
             $entityManager->flush();
             $idt = $tache->getId();
             $ListeTaches = new ListeTaches();
             $ListeTaches->setIdP($plan);
             $ListeTaches->setIdT($tache);
             
             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($ListeTaches);
             $entityManager->flush();

             return $this->redirectToRoute('planning');

 
             
        }
 
        return $this->render('Planning/TachePlanning.html.twig', [
         'form' => $form->createView(),
     ]);
 
 
 
 
     }
}

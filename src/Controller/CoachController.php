<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Coach;
use App\Form\CoachType;
use App\Repository\CoachRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class CoachController extends AbstractController
{
    /**
     * @Route("/coach", name="coach")
     */
    public function index(): Response
    {
        return $this->render('coach/index.html.twig', [
            'controller_name' => 'CoachController',
        ]);
    }
    /**
     * @Route("/Affichage",name="Affichage")
     */
    public function Affichage()
    {
        $repo = $this->getDoctrine()->getManager()->getRepository(Coach::class);
        $Co = $repo->findAll();    
        
        return $this->render('coach/Affichage.html.twig', [
            'coach' => $Co 
        ]);
    }
    /**
     * @Route("/add",name="add")
     */
    public function add(Request $request)
    {
        $coach=new Coach();
        $form=$this->createForm(CoachType::class,$coach);
        $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($request);
               if ($form->isSubmitted() && $form->isValid()) {
            $em= $this->getDoctrine()->getManager();
            $em->persist($coach);
            $em->flush();
            return $this->redirectToRoute('Affichage');
    }
    return $this->render('Coach/add.html.twig',[
        'form'=>$form->createView()
    ]);
}
}

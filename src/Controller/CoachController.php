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
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

use Ob\HighchartsBundle\Highcharts\Highchart;

class CoachController extends AbstractController
{
    /**
     * @Route("/admin ",name="Affichage")
     * 
     */
    public function index(): Response
    {
        $repo = $this->getDoctrine()->getManager()->getRepository(Coach::class);
        $Co = $repo->findAll();
        return $this->render('coach/Affichage.html.twig', [
            'coach' => $Co
        ]);
    }
    /**
     * @Route("/", name="coach")
     */
    public function Affichage()
    {
        $repo = $this->getDoctrine()->getManager()->getRepository(Coach::class);
        $Co = $repo->findAll();

        return $this->render('coach/affich.html.twig', [
            'coach' => $Co
        ]);
    }
    /**
     * @Route("/admin/{id}", name="show")
     */
    public function show($id,CoachRepository $repo)
    {
        $propri=$coach = $repo->find($id);
        return $this->render('Coach/show.html.twig', [
            'coach' => $propri
        ]);
    }
    
    
    /**
     * @Route("/add",name="add")
     */
    public function add(Request $request)
    {
        $coach = new Coach();
        $form = $this->createForm(CoachType::class, $coach);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($coach);
            $em->flush();
            $this->addFlash('success','le Coach a été bien ajouter   !');
            return $this->redirectToRoute('Affichage');
        }
        return $this->render('Coach/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/update/{id}",name="update")
     */
    public function update(Request $request, $id, CoachRepository $repo)
    {
        $coach = $repo->find($id);
        $form = $this->createForm(CoachType::class, $coach);
        $form->add('modifier', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash('success','le Coach a été bien modifier !');
            return $this->redirectToRoute('Affichage');
        }
        return $this->render('Coach/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}",name="delete")
     */
    function delete($id, CoachRepository $repo)
    {
        $coach = $repo->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($coach);
        $em->flush();
        $this->addFlash('success','le Coach a été bien supprimer !');
        return $this->redirectToRoute('Affichage');
    }
    /**
     * @Route("/searchCoach ", name="searchCoach")
     */
    public function searchCoach(Request $request, NormalizerInterface $Normalizer, CoachRepository $repo)
    {

        $requestString = $request->get('searchValue');
        $coachs = $repo->findCoachByNOM($requestString);
        
        return $this->render('coach/Affichage.html.twig', [
            'coach' => $coachs
        ]);
    }
   
}

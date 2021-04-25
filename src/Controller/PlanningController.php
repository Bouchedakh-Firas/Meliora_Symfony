<?php

namespace App\Controller;

use App\Entity\Citations;
use App\Entity\EBooks;
use App\Entity\ListeTaches;
use App\Entity\Musique;
use App\Entity\Planning;
use App\Entity\Tache;
use App\Entity\Video;
use App\Form\PlanningType;
use App\Form\TacheType;
use App\Repository\ListeTachesRepository;
use App\Repository\PlanningRepository;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class PlanningController extends AbstractController
{
    /**
     * @Route("/yy", name="planning")
     */
    public function index(): Response
    {
        return $this->render('planning/index.html.twig', [
            'controller_name' => 'PlanningController',
        ]);
        
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/plan", name="AjouterPlanning")
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

             return $this->redirectToRoute('ContentList', ['id' => $id]);
        }
 
        return $this->render('Planning/index.html.twig', [
         'form' => $form->createView(),
     ]);
 
 
 
 
     }
     
      /**
       * @IsGranted("ROLE_ADMIN")
     * @Route("/TacheAjouter", name="AjouterTacheP")
     */
    public function AjouterTache(Request $request) {
        $tache = new Tache();
        $form = $this->createForm(TacheType::class, $tache);
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
       * @IsGranted("ROLE_ADMIN")
     * @Route("/ListerContent/{id}", name="ContentList")
     */
    public function ListerContent(Request $request, $id) {
        $repo1 = $this->getDoctrine()->getRepository(Video::class);
        $Videos = $repo1->findAll();
        $repo2 = $this->getDoctrine()->getRepository(Citations::class);
        $Citation = $repo2->findAll();
        $repo3 = $this->getDoctrine()->getRepository(Musique::class);
        $Musique = $repo3->findAll();
        $repo4 = $this->getDoctrine()->getRepository(EBooks::class);
        $Ebook = $repo4->findAll();
        
 
        return $this->render('Planning/tacheP.html.twig', [
            'video' => $Videos,
            'citation' => $Citation,
            'musique' => $Musique,
            'Ebook' => $Ebook,
            'id' => $id,
     ]);
 
 
 
 
     }

     /**
      * @IsGranted("ROLE_ADMIN")
     * @Route("/ListerContent/{id}/{idc}/{type}", name="ContentAdd")
     */
    public function ContentAdd(Request $request,  $id,  $idc,  $type) {
        $tache = new Tache();
        $ltache = new ListeTaches();
       
        
        $form = $this->createFormBuilder($ltache)
            ->add('nomTache', TextType::class)
            ->add('date', DateTimeType::class)
            ->add('submit', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $tache->setNomTache($data->getNomTache());
            $ltache->setNomTache($data->getNomTache());
            $ltache->setDate($data->getDate());
            if($type=="musique"){
                $tache->setIdM($idc);
            $tache->setLike(0);
            $tache->setDislike(0);
                $tache->setIdM($idc);
                $tache->setTypeTache($type);
                $ltache->setTypeTache($type);
                
            }
            if($type=="video"){
              
               
            $tache->setIdV($idc);
            $tache->setLike(0);
            $tache->setDislike(0);
            $tache->setIdnonnull($idc);
            $tache->setTypeTache("video");
            $ltache->setTypeTache($type);
            }
            if($type=="citaion"){
                $repo2 = $this->getDoctrine()->getRepository(Citations::class);
                $Citation = $repo2->find($idc);
                $tache->setIdC($Citation);
            $tache->setLike(0);
            $tache->setDislike(0);
            $tache->setIdC($Citation);
            $tache->setTypeTache($type);
            $ltache->setTypeTache($type);
            }
            if($type=="ebook"){
                
                $repo2 = $this->getDoctrine()->getRepository(EBooks::class);
                $ebook = $repo2->find($idc);
                $tache->setIdE($ebook);
            $tache->setLike(0);
            $tache->setDislike(0);
            $tache->setIdE($ebook);
            $tache->setTypeTache($type);
            $ltache->setTypeTache($type);
            
            }
            $entityManager = $this->getDoctrine()->getManager();
            $repo1 = $this->getDoctrine()->getRepository(Planning::class);
            $pd= new Planning();
            $pd = $repo1->find($id);
            dump($pd);
            $ltache->setIdP($pd);
           /* $entityManager->persist($tache);
            
            dump($tache);
            $entityManager->flush();
            $dd = $tache->getId();
            $ltache->setIdT($dd);*/
            $entityManager->persist($ltache);
            $entityManager->flush();
            dump($ltache);
            return $this->redirectToRoute('PlanningConsulter', ['id' => $id]);

            // ... perform some action, such as saving the data to the database

            
        }
        
        
 
        return $this->render('Planning/ListeTacheP.html.twig', [
            'form' => $form->createView(),
            
     ]);
 
 
 
 
     }

      /**
       * @IsGranted("ROLE_ADMIN")
     * @Route("/Planning/{id}", name="PlanningConsulter")
     */
    public function ConsulterP(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $repo1 = $this->getDoctrine()->getRepository(Planning::class);
        $p = $repo1->find($id);
        $form = $this->createForm(PlanningType::class, $p);

        $r = $this->getDoctrine()->getRepository(ListeTaches::class);
        $l = $r->findBy(array('idP' => $id));
        dump($l);
      
      
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
             $p = $form->getData();
             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($p);
             $entityManager->flush();
           
            # $p = new Planning();
             #$repo = $this->getDoctrine()->getRepository(Planning::class);
             #$p = $repo->find($plan);
            # $id = $p->getId();

             return $this->redirectToRoute('PlanningConsulter', ['id' => $id]);
        }
 
        
        
 
        return $this->render('Planning/consulterP.html.twig', [
            'form' => $form->createView(),
            'l'=>$l,
            'id' => $id,
     ]);
 
 
 
 
     }

     /**
      * @IsGranted("ROLE_ADMIN")
     * @Route("Planning/{id}/supprimer{idt}", name="supprimerTacheP")
     */
    public function supprimerTacheP($id,  $idt, ListeTachesRepository $repository){
        $tache = $repository->findOneBy(array('id' => $idt));
        $em=$this->getDoctrine()->getManager();
        $em->remove($tache);
        $em->flush();
       
        return $this->redirectToRoute('PlanningConsulter', ['id' => $id]);
    }


    /**
     * @Route("Planning/{id}/Done{idt}", name="DoneTacheP")
     */
    public function DoneTacheP($id,  $idt, ListeTachesRepository $repository){
        $tache = $repository->findOneBy(array('id' => $idt));
        $tache->setEtatDuTache(1);
        $em=$this->getDoctrine()->getManager();
        $em->persist($tache);
        $em->flush();
       
        return $this->redirectToRoute('PlanningConsulter', ['id' => $id]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/Planning/{id}/modifier", name="modifierP")
     */
    public function ModifierP(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $repo1 = $this->getDoctrine()->getRepository(Planning::class);
        $p = $repo1->find($id);
        $form = $this->createForm(PlanningType::class, $p);

        $r = $this->getDoctrine()->getRepository(ListeTaches::class);
        $l = $r->findBy(array('idP' => $id));
        dump($l);
      
      
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
             $p = $form->getData();
             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($p);
             $entityManager->flush();
           
            # $p = new Planning();
             #$repo = $this->getDoctrine()->getRepository(Planning::class);
             #$p = $repo->find($plan);
            # $id = $p->getId();

             return $this->redirectToRoute('ListerP');
        }
 
        
        
 
        return $this->render('Planning/consulterP.html.twig', [
            'form' => $form->createView(),
            'l'=>$l,
            'id' => $id,
     ]);
 
 
 
 
     }

      /**
       * @IsGranted("ROLE_ADMIN")
     * @Route("/ListerPlanning", name="ListerP")
     */
    public function ListerP(Request $request) {
        $repo = $this->getDoctrine()->getRepository(Planning::class);
        $plannings = $repo->findAll();
       
        
 
        return $this->render('Planning/ListerP.html.twig', [
            'plans' => $plannings,
            
     ]);
 
 
 
 
     }

     /**
      * 
     * @Route("/searchStudentx ", name="searchStudentx")
     */
    public function searchStudentx(Request $request,NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Planning::class);
        $requestString=$request->get('searchValue');
       // $students = $repository->findBy(array('nomP' => $requestString));
       $students = $repository->createQueryBuilder('a')
        // Filter by some parameter if you want
        ->where('a.nomP LIKE :nsc')
            ->setParameter('nsc', '%'.$requestString.'%')
            ->getQuery()
            ->getResult();
        $jsonContent = $Normalizer->normalize($students, 'json',['groups'=>'students:read']);
        $retour=json_encode($jsonContent);
        return new Response($retour);
      
    }



        /**
         * @IsGranted("ROLE_ADMIN")
     * @Route("/ListerPlanning/supprimer{id}", name="supprimerP")
     */
    public function SupprimerP(Request $request,$id) {
        $repo = $this->getDoctrine()->getRepository(Planning::class);
        $planning = $repo->find($id);
        $r = $this->getDoctrine()->getRepository(ListeTaches::class);
        
        $tl = $r->findBy(array('idP' => $id));
        $em=$this->getDoctrine()->getManager();
        $em->remove($planning);
        $em->flush();
        dump($tl);
        if ($tl != null)
         {
            foreach ($tl as $t) {
                $t->setIdP(null);
                $em=$this->getDoctrine()->getManager();
                $em->persist($t);
                $em->flush();
                $em=$this->getDoctrine()->getManager();
                $em->remove($t);
                $em->flush();
            }
        }
        $em=$this->getDoctrine()->getManager();
        $em->remove($planning);
        $em->flush();
        
 
        return $this->redirectToRoute('ListerP');
 
 
 
 
     }
}

<?php

namespace App\Controller;

use App\Entity\Citations;
use App\Entity\EBooks;
use App\Entity\ListeTaches;
use App\Entity\Musique;
use App\Entity\Planning;
use App\Entity\Tache;
use App\Entity\User;
use App\Entity\Video;
use App\Form\PlanningType;
use App\Form\TacheType;
use App\Repository\ListeTachesRepository;
use App\Repository\PlanningRepository;
use Doctrine\ORM\Decorator\EntityManagerDecorator;
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
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class PlanningController extends AbstractController
{
     /**
     * @Route("/ListerMobile", name="ListerMobile")
     */
    public function ListerMobile(Request $request,SerializerInterface $serializer,PlanningRepository $repo)
    {
       $plan = $repo->findAll();
       $ser = new Serializer([new ObjectNormalizer()]);
      $formated =$ser->normalize($plan);
       $json=$serializer->serialize($plan,'json',['groups'=>'Planning']);
      
       //dd($json);
       
       
       return new JsonResponse($formated);

    }

     /**
    * @Route("/searchplan/{n}", name="searchplan")
    */
    public function searchStudentx2(Request $request, NormalizerInterface $Normalizer,SerializerInterface $serializer,$n)
    {
        $repository = $this->getDoctrine()->getRepository(Planning::class);
        
        //$students = $repository->findBy(array('nomP' => $requestString));
        $plan = $repository->createQueryBuilder('a')
        // Filter by some parameter if you want
        ->where('a.nomP LIKE :nsc')
            ->setParameter('nsc', '%'.$n.'%')
            ->getQuery()
            ->getResult();
        

            $ser = new Serializer([new ObjectNormalizer()]);
            $formated =$ser->normalize($plan);
             $json=$serializer->serialize($plan,'json',['groups'=>'Planning']);
        //$jsonContent = $Normalizer->normalize($students, 'json', ['groups'=>'students:read']);
       // $retour=json_encode($jsonContent);
      //  return new Response($retour);
      return new JsonResponse($formated);
    }


    /**
     * @Route("/ListerMobileTache/{id}", name="ListerMobileTa")
     */
     public function ListerMobileTache(Request $request,SerializerInterface $serializer,ListeTachesRepository $repo,PlanningRepository $repo1,$id)
     {
         $plan = $repo1->find($id);
      
       $tache = $repo->findBy(array('idP' => $plan));
       
      /*  $tache = $repo->createQueryBuilder('a')
        // Filter by some parameter if you want
            ->where('a.idP = :nsc ')
            ->setParameter('nsc', $id)
            ->getQuery()
            ->getResult();*/
        
        $ser = new Serializer([new ObjectNormalizer()]);
       $formated =$ser->normalize($tache);
        //$json=$serializer->serialize($tache,'json',['groups'=>'tache']);
       
        //dd($json);
        
        
        return new JsonResponse($formated);
 
     }


    /**
     * @Route("/planMobile", name="AjouterPlanningMobilejson")
     */
    public function AjouterPlanMobilejson(Request $request,SerializerInterface $serializer,EntityManagerDecorator $em)
    {
       $content = $request->getContent();
       $data=$serializer->deserialize($content,Planning::class,'json');
       $em->persist($data);
       $em->flush();
       return new Response('Planning ajouter avec success');

    }

     /**
     * @Route("/planMobile/{id}", name="SupprimerPlanningMobile")
     */
    public function supprimerPlanMobile(Request $request, $id,PlanningRepository $repo )
    {
       
       $p = $repo->findOneBy(array('id' => $id));
        $em=$this->getDoctrine()->getManager();
        $em->remove($p);
        $em->flush();
       return new Response('Planning mobile supprimer avec success');

    }

     /**
     * @Route("/planMobile/{id}/{nom}/{desc}", name="modifierPlanningMobile")
     */
    public function modifierPlanMobile(Request $request, $id,PlanningRepository $repo,$nom,$desc )
    {
       
       $p = $repo->findOneBy(array('id' => $id));
       $p->setNomP($nom);
       $p->setDescription($desc);
        $em=$this->getDoctrine()->getManager();
        $em->persist($p);
        $em->flush();
       return new Response('Planning mobile modifier avec success');

    }

     /**
     * @Route("/planMobile/{desc}/{n}", name="AjouterPlanningMobile")
     */
    public function AjouterPlanMobile(Request $request, $desc ,$n )
    {
       $p = new Planning();
       $p->setNomP($n);
       $p->setDescription($desc);
       $entityManager = $this->getDoctrine()->getManager();
       $entityManager->persist($p);
       $entityManager->flush();
       return new Response('Planning mobile ajouter avec success');

    }
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
    public function AjouterPlan(Request $request)
    {
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
    public function AjouterTache(Request $request)
    {
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
    public function ListerContent(Request $request, $id)
    {
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
    public function ContentAdd(Request $request, $id, $idc, $type)
    {
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
            if ($type=="musique") {
                $tache->setIdM($idc);
                $tache->setLike(0);
                $tache->setDislike(0);
                $tache->setIdM($idc);
                $tache->setTypeTache($type);
                $ltache->setTypeTache($type);
            }
            if ($type=="video") {
                $tache->setIdV($idc);
                $tache->setLike(0);
                $tache->setDislike(0);
                $tache->setIdnonnull($idc);
                $tache->setTypeTache("video");
                $ltache->setTypeTache($type);
            }
            if ($type=="citaion") {
                $repo2 = $this->getDoctrine()->getRepository(Citations::class);
                $Citation = $repo2->find($idc);
                $tache->setIdC($Citation);
                $tache->setLike(0);
                $tache->setDislike(0);
                $tache->setIdC($Citation);
                $tache->setTypeTache($type);
                $ltache->setTypeTache($type);
            }
            if ($type=="ebook") {
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
    public function ConsulterP(Request $request, $id)
    {
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
    public function supprimerTacheP($id, $idt, ListeTachesRepository $repository)
    {
        $tache = $repository->findOneBy(array('id' => $idt));
        $em=$this->getDoctrine()->getManager();
        $em->remove($tache);
        $em->flush();
       
        return $this->redirectToRoute('PlanningConsulter', ['id' => $id]);
    }


    /**
     * @Route("Planning/{id}/Done{idt}", name="DoneTacheP")
     */
    public function DoneTacheP($id, $idt, ListeTachesRepository $repository)
    {
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
    public function ModifierP(Request $request, $id)
    {
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
    public function ListerP(Request $request)
    {
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
    public function searchStudentx(Request $request, NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Planning::class);
        $requestString=$request->get('searchValue');
        $students = $repository->findBy(array('nomP' => $requestString));
        $jsonContent = $Normalizer->normalize($students, 'json', ['groups'=>'students:read']);
        $retour=json_encode($jsonContent);
        return new Response($retour);
    }



    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/ListerPlanning/supprimer{id}", name="supprimerP")
     */
    public function SupprimerP(Request $request, $id)
    {
        $repo = $this->getDoctrine()->getRepository(Planning::class);
        $planning = $repo->find($id);
        $r = $this->getDoctrine()->getRepository(ListeTaches::class);
        
        $tl = $r->findBy(array('idP' => $id));
        $em=$this->getDoctrine()->getManager();
        $em->remove($planning);
        $em->flush();
        dump($tl);
        if ($tl != null) {
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
    ///////////////////////COACH///////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////



    /**
     * @Route("/ListerPlanningC", name="ListerPC")
     */
    public function ListerPC(Request $request, PlanningRepository $repository)
    {
        $repo = $this->getDoctrine()->getRepository(Planning::class);
        $user = $this->getUser();
          
        $plannings = $repository->createQueryBuilder('a')
            // Filter by some parameter if you want
            ->where('a.idU = :nsc ')
                ->setParameter('nsc', $user->getId())
                ->getQuery()
                ->getResult();
    
            
        dump($user->getId());
           
            
     
        return $this->render('planning_user/ListerPC.html.twig', [
                'plans' => $plannings,
                
         ]);
    }
    /**
     * @Route("/planC", name="AjouterPlanningCoach")
     */
    public function AjouterPlanC(Request $request, \Swift_Mailer $mailer)
    {
        $id=5;
        
        $plan = new Planning();
        $form = $this->createForm(PlanningType::class, $plan);
        $repo = $this->getDoctrine()->getRepository(User::class);
        $date = new \DateTime('now');
        $plan->setDateCreation($date);
     
        dump($plan);
        
        dump($plan);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $plan = $form->getData();
            
            
            
            // $plan->setIdU($us->getId());
            $entityManager = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $plan->setDateCreation($date);
            $plan->setIdU($user);
            $entityManager->persist($plan);
            $entityManager->flush();
            
            $repo1 = $this->getDoctrine()->getRepository(Planning::class);
            $p = $repo1->find($plan);

            $message = (new \Swift_Message('Nouveau Planning'))
        ->setFrom('testindicateur@gmail.com')
        ->setTo('bouchedakh.firas@gmail.com')
        ->setBody(
            $this->renderView(
                // templates/emails/registration.html.twig
                'planning_user/mail.html.twig'
            ),
            'text/html'
        );
            dump($message);
            $mailer->send($message);
        
            return $this->redirectToRoute('ListerPC');
          
            # $p = new Planning();
             #$repo = $this->getDoctrine()->getRepository(Planning::class);
             #$p = $repo->find($plan);
            # $id = $p->getId();

            // return $this->redirectToRoute('ContentList', ['id' => $id]);
        }
 
        return $this->render('planning_user/indexCoach.html.twig', [
         'form' => $form->createView(),
     ]);
    }

    /**
    *
    * @Route("/PlanningC/{id}/modifier", name="modifierPC")
    */
    public function ModifierPC(Request $request, $id)
    {
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

            return $this->redirectToRoute('ListerPC');
        }
        return $this->render('planning_user/consulterPC.html.twig', [
            'form' => $form->createView(),
            'l'=>$l,
            'id' => $id,
     ]);
    
    }

     /**
     * @Route("/ListerContentC/{id}", name="ContentListC")
     */
    public function ListerContentC(Request $request, $id)
    {
        $repo1 = $this->getDoctrine()->getRepository(Video::class);
        $Videos = $repo1->findAll();
        $repo2 = $this->getDoctrine()->getRepository(Citations::class);
        $Citation = $repo2->findAll();
        $repo3 = $this->getDoctrine()->getRepository(Musique::class);
        $Musique = $repo3->findAll();
        $repo4 = $this->getDoctrine()->getRepository(EBooks::class);
        $Ebook = $repo4->findAll();
        
 
        return $this->render('planning_user/tachePCoach.html.twig', [
            'video' => $Videos,
            'citation' => $Citation,
            'musique' => $Musique,
            'Ebook' => $Ebook,
            'id' => $id,
     ]);
    }



    /**
    * @Route("/ListerContentC/{id}/{idc}/{type}", name="ContentAddC")
    */
    public function ContentAddC(Request $request, $id, $idc, $type)
    {
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
            if ($type=="musique") {
                $tache->setIdM($idc);
                $tache->setLike(0);
                $tache->setDislike(0);
                $tache->setIdM($idc);
                $tache->setTypeTache($type);
                $ltache->setTypeTache($type);
            }
            if ($type=="video") {
                $tache->setIdV($idc);
                $tache->setLike(0);
                $tache->setDislike(0);
                $tache->setIdnonnull($idc);
                $tache->setTypeTache("video");
                $ltache->setTypeTache($type);
            }
            if ($type=="citaion") {
                $repo2 = $this->getDoctrine()->getRepository(Citations::class);
                $Citation = $repo2->find($idc);
                $tache->setIdC($Citation);
                $tache->setLike(0);
                $tache->setDislike(0);
                $tache->setIdC($Citation);
                $tache->setTypeTache($type);
                $ltache->setTypeTache($type);
            }
            if ($type=="ebook") {
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
            return $this->redirectToRoute('PlanningConsulterC', ['id' => $id]);

            // ... perform some action, such as saving the data to the database
        }
        
        
 
        return $this->render('Planning_user/ListeTachePC.html.twig', [
            'form' => $form->createView(),
            
     ]);
    }

      /**
     * @Route("/PlanningC/{id}", name="PlanningConsulterC")
     */
    public function ConsulterPC(Request $request, $id)
    {
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

            return $this->redirectToRoute('PlanningConsulterC', ['id' => $id]);
        }
 
        
        
 
        return $this->render('Planning_user/consulterPC.html.twig', [
            'form' => $form->createView(),
            'l'=>$l,
            'id' => $id,
     ]);
    }

}
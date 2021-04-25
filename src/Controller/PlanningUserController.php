<?php

namespace App\Controller;

use Symfony\Component\Security\Core\Security;
use App\Entity\ListeTaches;
use App\Entity\Planning;
use App\Entity\Tache;
use App\Entity\User;
use App\Form\PlanningType;
use App\Repository\ListeTachesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use App\Entity\Citations;
use App\Entity\EBooks;
use Dompdf\Dompdf;
use Dompdf\Options;


use App\Entity\Musique;

use App\Entity\Video;

use App\Form\TacheType;

use App\Repository\PlanningRepository;
use App\Repository\TacheRepository;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\Material\BarChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\Extension\Core\Type\TextType;



class PlanningUserController extends AbstractController
{
    /**
     * @Route("/planning/user", name="planning_user")
     */
    public function index(): Response
    {
        return $this->render('planning_user/index.html.twig', [
            'controller_name' => 'PlanningUserController',
        ]);
    }

    /**
     * @Route("/planU", name="AjouterPlanningUser")
     */
    public function AjouterPlan(Request $request, \Swift_Mailer $mailer)
    {
        $id=5;
        $u = new User();
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
            $mailer->send($message);
        
            return $this->redirectToRoute('ListerPU');
          
            # $p = new Planning();
             #$repo = $this->getDoctrine()->getRepository(Planning::class);
             #$p = $repo->find($plan);
            # $id = $p->getId();

            // return $this->redirectToRoute('ContentList', ['id' => $id]);
        }
 
        return $this->render('planning_user/index.html.twig', [
         'form' => $form->createView(),
     ]);
    }

      
    /**
     * @Route("/TacheAjouterU", name="AjouterTachePUser")
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
 
        return $this->render('planning_user/index.html.twig', [
         'form' => $form->createView(),
     ]);
    }


    /**
     * @Route("/ListerContentU/{id}", name="ContentListU")
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
        
 
        return $this->render('planning_user/tacheP.html.twig', [
            'video' => $Videos,
            'citation' => $Citation,
            'musique' => $Musique,
            'Ebook' => $Ebook,
            'id' => $id,
     ]);
    }

    /**
    * @Route("/ListerContentU/{id}/{idc}/{type}", name="ContentAddU")
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
            return $this->redirectToRoute('PlanningConsulterU', ['id' => $id]);

            // ... perform some action, such as saving the data to the database
        }
        
        
 
        return $this->render('planning_user/ListeTacheP.html.twig', [
            'form' => $form->createView(),
            
     ]);
    }

    /**
     * @Route("/PlanningU/{id}", name="PlanningConsulterU")
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

            return $this->redirectToRoute('PlanningConsulterU', ['id' => $id]);
        }
 
        
        
 
        return $this->render('planning_user/consulterP.html.twig', [
            'form' => $form->createView(),
            'l'=>$l,
            'id' => $id,
     ]);
    }

    /**
     * @Route("Planningu/{id}/supprimer{idt}", name="supprimerTachePU")
     */
    public function supprimerTacheP($id, $idt, ListeTachesRepository $repository)
    {
        $tache = $repository->findOneBy(array('id' => $idt));
        $em=$this->getDoctrine()->getManager();
        $em->remove($tache);
        $em->flush();
       
        return $this->redirectToRoute('PlanningConsulterU', ['id' => $id]);
    }

     /**
     * @Route("Planningu{id}/afficher", name="afficherPlanning")
     */
    public function AfficherP($id, PlanningRepository $repository,Request $request)
    {
       /* $tache = $repository->findOneBy(array('id' => $id));
        $form = $this->createForm(PlanningType::class, $tache);*/
        $em = $this->getDoctrine()->getManager();
        $repo1 = $this->getDoctrine()->getRepository(Planning::class);
        $p = $repo1->find($id);
        $form = $this->createForm(PlanningType::class, $p);

        $r = $this->getDoctrine()->getRepository(ListeTaches::class);
        $l = $r->findBy(array('idP' => $id));
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

            return $this->redirectToRoute('ListerPU');
        }
       
        return $this->render('planning_user/consulterP.html.twig', [
            'form' => $form->createView(),
            'l'=>$l,
            'id' => $id,
            
     ]);
        
    }



    

    /**
     * @Route("/PlanningU/{id}/modifier", name="modifierPU")
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

            return $this->redirectToRoute('ListerPU');
        }
 
        
        
 
        return $this->render('planning_user/consulterP.html.twig', [
            'form' => $form->createView(),
            'l'=>$l,
            'id' => $id,
     ]);
    }

    /**
     * @Route("/ListerPlanningU", name="ListerPU")
     */
    public function ListerP(Request $request,PlanningRepository $repository)
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
       
        
 
        return $this->render('planning_user/ListerP.html.twig', [
            'plans' => $plannings,
            
     ]);
    }

    /**
     * @Route("/ListerPlanningUD", name="ListerPUD")
     */
    public function ListerPdfault(Request $request,PlanningRepository $repository)
    {
        $repo = $this->getDoctrine()->getRepository(Planning::class);
        $user = $this->getUser();
       
        $plannings = $repository->createQueryBuilder('a')
        // Filter by some parameter if you want
        ->where('a.idU IS NULL')
           
            ->getQuery()
            ->getResult();

       
        
 
        return $this->render('planning_user/ListerPdefault.html.twig', [
            'plans' => $plannings,
            
     ]);
    }

     /**
     * @Route("/ListerPlanningUDadd{id}", name="ListerPUDadd")
     */
    public function ListerPdfaultadd($id,Request $request,PlanningRepository $repository)
    {
        $repo = $this->getDoctrine()->getRepository(Planning::class);
        $user = $this->getUser();
       
        $plan = $repository->find($id);
        $plan->setIdU($user);
        $em=$this->getDoctrine()->getManager();
        $em->persist($plan);
        $em->flush();
        
        
       
        
 
        return $this->redirectToRoute('ListerPU');
    }

    /**
    * @Route("/searchStudentx2", name="searchStudentx2")
    */
    public function searchStudentx2(Request $request, NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Planning::class);
        $requestString=$request->get('searchValue');
        //$students = $repository->findBy(array('nomP' => $requestString));
        $students = $repository->createQueryBuilder('a')
        // Filter by some parameter if you want
        ->where('a.nomP LIKE :nsc')
            ->setParameter('nsc', '%'.$requestString.'%')
            ->getQuery()
            ->getResult();
        

       
        $jsonContent = $Normalizer->normalize($students, 'json', ['groups'=>'students:read']);
        $retour=json_encode($jsonContent);
        return new Response($retour);
    }



    /**
     * @Route("/ListerPlanningU/supprimer{id}", name="supprimerPU")
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
        
 
        return $this->redirectToRoute('ListerPU');
    }

    /**
     * @Route("Planning/{id}/liker", name="LikerP")
     */
    public function LikerP($id, PlanningRepository $repository)
    {
        $tache = $repository->findOneBy(array('id' => $id));
        $i = $tache->getLiker();
        $tache->setLiker($i+1);
        dump($tache);
        $em=$this->getDoctrine()->getManager();
        $em->persist($tache);
        $em->flush();
       
        return $this->redirectToRoute('ListerPU');
    }
    /**
     * @Route("Planning/{id}/Disiker", name="DisikerP")
     */
    public function DislikerP($id, PlanningRepository $repository)
    {
        $tache = $repository->findOneBy(array('id' => $id));
        $i = $tache->getDisliker();
        $tache->setDisliker($i+1);
        dump($tache);
        $em=$this->getDoctrine()->getManager();
        $em->persist($tache);
        $em->flush();
       
        return $this->redirectToRoute('ListerPU');
    }

    /**
    * @Route("Stat", name="stat")
    */
    public function stat(ListeTachesRepository $repository)
    {
        /* $accounts = "video";
           // 1. Obtain doctrine manager
           $em = $this->getDoctrine()->getManager();

           // 2. Setup repository of some entity
           $repoArticles = $em->getRepository(ListeTaches::class);

           // 3. Query how many rows are there in the Articles table
           $totalArticles = $repoArticles->createQueryBuilder('a')
               // Filter by some parameter if you want
               ->select('COUNT(a.typeTache)')
               ->where('a.typeTache = :video')
               ->setParameter('video', $accounts)

               ->getQuery()
               ->getResult();

              $vid =  $totalArticles;*/
          
        // 4. Return a number as response
        // e.g 972
        $v=0;
        $m=0;
        $c=0;
        $b=0;
        $d=0;
        $u=0;
        $taches = $repository->findAll();
        foreach ($taches as $t) {
            if ($t->getEtatDuTache()==0) {
                $u++;
            }
             if ($t->getEtatDuTache()==1) {
                $d++;
            }
           if ($t->getTypeTache()=="video") {
              $v++;
          }
          if ($t->getTypeTache()=="musique") {
              $m++;
          }
        if ($t->getTypeTache()=="citaion") {
            $c++;
        }
        if ($t->getTypeTache()=="ebook") {
            $b++;
        }


          }
          $pieChart = new PieChart();
    $pieChart->getData()->setArrayToDataTable(
        [['Task', 'type'],
         ['video',     $v],
         ['citation',      $c],
         ['musique',  $m],
         ['ebook', $b],
         
        ]
    );
    $pieChart->getOptions()->setTitle('repartition des types des taches');
    $pieChart->getOptions()->setHeight(750);
    $pieChart->getOptions()->setWidth(1450);
    $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
    $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
    $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
    $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
    $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);
    $pieChart->getOptions()->setIs3D(true);


    //barchart code

    $bar = new BarChart();
$bar->getData()->setArrayToDataTable([
    ['count:', 'etat'],
    [$d, 'tache fini'],
    [$u, 'tache non fini'],
    
]);
$bar->getOptions()->setTitle('rapport de status des taches');

$bar->getOptions()->getHAxis()->setMinValue(0);
$bar->getOptions()->getVAxis()->setTitle('nombre des taches');
$bar->getOptions()->setWidth(900);
$bar->getOptions()->setHeight(500);
$bar->getOptions()->getTitleTextStyle()->setBold(true);
$bar->getOptions()->getTitleTextStyle()->setColor('#009900');
$bar->getOptions()->getTitleTextStyle()->setItalic(true);
$bar->getOptions()->getTitleTextStyle()->setFontName('Arial');
$bar->getOptions()->getTitleTextStyle()->setFontSize(20);


    return $this->render('planning/stat.html.twig', array('piechart' => $pieChart,'barchart'=>$bar));
       
        
    }

    /**
    * @Route("/pdfgen", name="pdfgen")
    */
    public function pdfgen()
    {
        $repo = $this->getDoctrine()->getRepository(Planning::class);
        $plannings = $repo->findAll();
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->setIsRemoteEnabled(true);
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('planning_user/pdf.html.twig', [
            'title' => "Welcome to our PDF Test",
            'plans'=>$plannings
        ]);
        
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);
    }
        }
    

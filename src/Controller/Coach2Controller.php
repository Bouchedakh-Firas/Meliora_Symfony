<?php

namespace App\Controller;
use App\Entity\Coach;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CoachRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CoachType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
class Coach2Controller extends AbstractController
{
    /**
     * @Route("/coach2admin", name="coach2")
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
     * @Route("/coach2user", name="coach2user")
     */
    public function Affichage(PaginatorInterface $paginator, Request $request)
    {
        $repo = $this->getDoctrine()->getManager()->getRepository(Coach::class);


        $Co = $paginator->paginate(
            $repo->findAll(),
            $request->query->get('page', 1)/*le numéro de la page à afficher*/,
            8/*nbre d'éléments par page*/

        );

        return $this->render('coach/affich.html.twig', [
            'coach' => $Co
        ]);
    }
    /**
     * @Route("/adminUser/{id}", name="show")
     */
    public function show($id)
    {
        $repo = $this->getDoctrine()->getManager()->getRepository(Coach::class);
        $propri= $repo->find($id);
        return $this->render('Coach/show.html.twig', [
            'coach' => $propri
        ]);
            
    }


    /**
     * @Route("/addcoach",name="add")
     */
    public function add(Request $request)
    {
        $coach = new Coach();
        $form = $this->createForm(CoachType::class, $coach);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
             /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $form->get('image')->getData();

            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('brochures_directory'),
                $fileName
           );
            $coach->setImage($fileName);
            $em = $this->getDoctrine()->getManager();
            $em->persist($coach);
            $em->flush();
            $this->addFlash('success', 'le Coach a été bien ajouter   !');
          
            return $this->redirectToRoute('Affichage');
            
        }
        return $this->render('Coach/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/updatecoach/{id}",name="update")
     */
    public function update(Request $request, $id, CoachRepository $repo)
    {
        $coach = $repo->find($id);
        $form = $this->createForm(CoachType::class, $coach);
        $form->add('modifier', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $form->get('image')->getData();

            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('brochures_directory'),
                $fileName
            );
            $coach->setImage($fileName);
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash('success', 'le Coach a été bien modifier !');
            
            return $this->redirectToRoute('Affichage');
           // return $this->redirect($this->generateUrl('app_product_list'));
        }
        return $this->render('Coach/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/deleteCoach/{id}",name="delete")
     */
    function delete($id, CoachRepository $repo,MailerInterface $mailer)
    {
        $coach = $repo->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($coach);
        $em->flush();
        $this->addFlash('success', 'le Coach a été bien supprimer !');
        
        $email = (new Email())
            ->from('meliora.project2021@gmail.com')
            ->to('kenza.ghenimi@gmail.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Mauvaise nouvelle a annoncer!')
            ->text(' On est navré !')
            ->html('<p>On vous informe que vous etes plus membre dans notre site meliora</p>');

        $mailer->send($email);
        return $this->redirectToRoute('Affichage');
    }
    /**
     * @Route("/searchCoach ", name="searchCoach")
     */
    public function searchCoach(Request $request, NormalizerInterface $Normalizer, CoachRepository $repo)
    {

        $requestString = $request->get('searchValue');
        $coachs = $repo->findCoachByNOM($requestString);
        $jsonContent = $Normalizer->normalize($coachs, 'json', ['groups' => 'coachs:read']);
        $retour = json_encode($jsonContent);
        return new Response($retour);
        /* return $this->render('coach/Affichage.html.twig', [
            'coach' => $coachs
        ]);*/
    }
      /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }
    /**
     * @Route("/triCoach", name="tri")
     */
    public function search(Request $request)
    {
        $coach = $this->getDoctrine()
            ->getManager()
            ->getRepository(Coach::class);
        $result =$coach->TriAction();     
        return $this->render('coach/Affichage.html.twig', [
            'coach' => $result,
        ]);

    }
    
}


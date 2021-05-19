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
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Services\QrcodeService;

class Coach2Controller extends AbstractController
{
    /**
     * @Route("/cc2admin", name="coach2")
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
     * @Route("/2usercc", name="2usercc")
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
     * @Route("/Usercc/{id}", name="show")
     */
    public function show($id)
    {
        $repo = $this->getDoctrine()->getManager()->getRepository(Coach::class);
        $propri = $repo->find($id);
        return $this->render('Coach/show.html.twig', [
            'coach' => $propri
        ]);
    }


    /**
     * @Route("/addadmin",name="add")
     */
    public function add(Request $request, QrcodeService $qrcodeService, MailerInterface $mailer, UserRepository  $userRepository)
    {
        $coach = new Coach();
        $form = $this->createForm(CoachType::class, $coach);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $form->get('image')->getData();

            $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('brochures_directory'),
                $fileName

            );
            $coach->setImage($fileName);
            $em = $this->getDoctrine()->getManager();
            $em->persist($coach);
            $em->flush();
            $message = "Bonjour! je suis  " . $coach->getnom() . ",
                 mon adresse est la suivant :" . $coach->getEmail() . " ,
                 si besoin de me contacter par telephone:" . $coach->getTel() .
                "";
            $this->addFlash('success', 'le Coach a été bien ajouter   !');
            $user = $userRepository->findAll();
            for ($i = 0; $i < count($user); $i++) {
                $m = "Bonjour  Mr/Mrs " . $user[$i]->getUsername() . ",
             un nouveau  coach :'" . $coach->getnom() . "' est dans notre site, 
             accedez  pour voir notre nouveau Coach, 
             Bonne journee
             ";
                $email = (new Email())
                    ->from('meliora.project2021@gmail.com')
                    ->to($user[$i]->getEmail())
                    ->text($m);
                $mailer->send($email);
            }
            $qrCode = $qrcodeService->qrcode($message, $coach->getId());
            return $this->redirectToRoute('Affichage');
        }
        return $this->render('Coach/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/updateadminc/{id}",name="update")
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

            $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();
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
     * @Route("/deleteadminc/{id}",name="delete")
     */
    function delete($id, CoachRepository $repo, MailerInterface $mailer)
    {
        $coach = $repo->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($coach);
        $em->flush();
        $this->addFlash('success', 'le Coach a été bien supprimer !');

        $email = (new Email())
            ->from('meliora.project2021@gmail.com')
            ->to('ghenimi.kenza5@gmail.com')
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
     * @Route("/searchCc ", name="searchCoach")
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
     * @Route("/triCc", name="tri")
     */
    public function search(Request $request)
    {
        $coach = $this->getDoctrine()
            ->getManager()
            ->getRepository(Coach::class);
        $result = $coach->TriAction();
        return $this->render('coach/Affichage.html.twig', [
            'coach' => $result,
        ]);
    }
    /**
     * @Route("/ratingcc ", name="ratingCoach")
     */
    public function ratingCoach(Request $request, NormalizerInterface $Normalizer, CoachRepository $repo)
    {

        $requestString = $request->get('searchValue');
        $coachs = $repo->fidAll();
        $jsonContent = $Normalizer->normalize($coachs, 'json', ['groups' => 'coachs:read']);
        $retour = json_encode($jsonContent);
        return new Response($retour);
        /* return $this->render('coach/Affichage.html.twig', [
            'coach' => $coachs
        ]);*/
    }


    /**
     * @Route("/2userccMobile", name="2userccMobile")
     */
    public function AffichageMobile()
    {

        $rec = $this->getDoctrine()->getManager()
            ->getRepository(Coach::class)
            ->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($rec);
        return new JsonResponse($formatted);
    }
/**
     * @Route("/updateadmincMobile/{id}",name="update")
     */
    public function updateMobile(Request $request, $id, CoachRepository $repo)
    {
        
        $em = $this->getDoctrine()->getManager();
        $rec = $em->getRepository(coach::class)->find($id);
        $em->persist($rec);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($rec);
        return new JsonResponse($formatted);
       
    }
    /**
     * @Route("/deleteadmincMobil/{id}",name="deletemobile")
     */
    function deleteMObile($id, CoachRepository $repo, MailerInterface $mailer)
    {
      

        $email = (new Email())
            ->from('meliora.project2021@gmail.com')
            ->to('ghenimi.kenza5@gmail.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Mauvaise nouvelle a annoncer!')
            ->text(' On est navré !')
            ->html('<p>On vous informe que vous etes plus membre dans notre site meliora</p>');

        $mailer->send($email);
        $em = $this->getDoctrine()->getManager();
        $rec = $em->getRepository(Coach::class)->find($id);
        $em->remove($rec);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($rec);
        return new JsonResponse($formatted);
    }
/**
     * @Route("/updateadmincMobile/{id}/{nom}/{prenom}/{mail}/{adresse}", name="updateadmincMobile")
     */
    public function ModifRecClAction($id,$nom, $adresse,$prenom,$mail)
    {
        $em = $this->getDoctrine()->getManager();
        $rec=$this->getDoctrine()->getRepository(Coach::class)->find($id);
        $rec->setNom($nom);
        $rec->setPrenom($prenom);
        $rec->setEmail($mail);
        $rec->setAdresse($adresse);
        $em->persist($rec);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($rec);
        return new JsonResponse($formatted);
    }

}

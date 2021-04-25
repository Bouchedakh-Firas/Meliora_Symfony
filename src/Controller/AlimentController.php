<?php

namespace App\Controller;

use App\Entity\Aliment;
use App\Form\AlimentType;
use App\Repository\AlimentRepository;
use http\Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Symfony\Component\String\Slugger\SluggerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\Mime\Email;


/**
 * @Route("/aliment")
 */
class AlimentController extends AbstractController

{
    /**
     * @return Response
     * @Route("/pdf",name="pdf", methods={"GET"})
     */
    public function pdf(AlimentRepository $repform ):Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();

        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);


        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('aliment/pdf.html.twig', [
            $aliments =$repform->findAll(),
            'aliments' => $aliments
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("ALIMENTS.pdf", [
            "Attachment" => true
        ]);
        return new Response('', 200, [
            'Content-Type' => 'application/pdf',
        ]);

    }

    /**
     * @return Response
     * @Route("/pdf/{idAliment}",name="pdfShow", methods={"GET"})
     */
    public function pdfShow(Aliment $aliment ):Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();

        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);


        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('aliment/pdfShow.html.twig', [

            'aliment' => $aliment
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("Descriptif.pdf", [
            "Attachment" => true
        ]);
        return new Response('', 200, [
            'Content-Type' => 'application/pdf',
        ]);

    }

    /**
     * @Route("/stat", name="aliment_stat", methods={"GET","POST"})
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
        return $this->render('aliment/Stat.html.twig', [
            'labels' => $labels,'datas' => $datas,
        ]);
    }
    /**
     * @Route("/", name="aliment_index", methods={"GET"})
     */
    public function index(Request $request,AlimentRepository $alimentRepository): Response
    {
        $triString=$request->get('triBy');
        $searchString=$request->get('searchValue');
        if($triString != null)
            $aliments = $alimentRepository->findBy([],[$triString => 'ASC']);
        elseif($searchString != null)
            $aliments = $alimentRepository->findByLibelle($searchString);
        else
            $aliments = $alimentRepository->findAll();
        return $this->render('aliment/index.html.twig', [
            'aliments' => $aliments,
        ]);
    }


    /**
     * @Route("/new", name="aliment_new", methods={"GET","POST"})
     */
    public function new(Request $request , \Swift_Mailer $mailer): Response
    {
        $aliment = new Aliment();
        $form = $this->createForm(AlimentType::class, $aliment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $imageFile = $form->get('image')->getData();
            $entityManager->persist($aliment);
            if($imageFile ) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . '.' . $imageFile->guessExtension();
                $aliment->setImage($newFilename);
            }
            $entityManager->flush();
//            $email = (new Email())
//                ->from('complexsportiftunis@gmail.com')
//                ->to('ahmed.gontara@esprit.tn')
//
//                ->subject('you have created a team!')
//                ->text('Complexes Sportif Sending you E-mail to tell you that you have successfully created a team!');
//
//
//            $mailer->send($email);
            $message = (new \Swift_Message('Hello Email'))
                ->setFrom('ahmed.gontara@esprit.tn')
                ->setTo('agontara6@gmail.com')
                ->setBody(
                    $this->renderView(
                    // templates/emails/registration.html.twig
                        'aliment/mail.html.twig'

                    ),
                    'text/html'
                );
            $mailer->send($message);

            return $this->redirectToRoute('aliment_index');
        }

        return $this->render('aliment/new.html.twig', [
            'aliment' => $aliment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idAliment}", name="aliment_show", methods={"GET"})
     */
    public function show(Aliment $aliment): Response
    {
        return $this->render('aliment/showAF.html.twig', [
            'aliment' => $aliment,
        ]);
    }

    /**
     * @Route("/{idAliment}/edit", name="aliment_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Aliment $aliment): Response
    {
        $form = $this->createForm(AlimentType::class, $aliment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            if($imageFile ) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . '.' . $imageFile->guessExtension();
                $aliment->setImage($newFilename);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('aliment_index');
        }

        return $this->render('aliment/edit.html.twig', [
            'aliment' => $aliment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idAliment}", name="aliment_delete", methods={"POST"})
     */
    public function delete(Request $request, Aliment $aliment): Response
    {
        if ($this->isCsrfTokenValid('delete'.$aliment->getIdAliment(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($aliment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('aliment_index');
    }


}

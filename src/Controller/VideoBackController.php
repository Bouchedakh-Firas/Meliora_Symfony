<?php

namespace App\Controller;

use App\Entity\Video;
use App\Form\VideoType;
use App\Repository\VideoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;


/**
 * @Route("/video/back")
 */
class VideoBackController extends AbstractController
{/**
 * @return Response
 * @Route("/pdfV",name="pdf", methods={"GET"})
 */
    public function pdf(VideoRepository  $repform ):Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();

        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);


        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('video_back/pdfV.html.twig', [
            $videos =$repform->findAll(),
            'videos' =>  $videos
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("VideoListe.pdf", [
            "Attachment" => true
        ]);
        return new Response('', 200, [
            'Content-Type' => 'application/pdf',
        ]);

    }

    /**
     * @return Response
     * @Route("/pdf/{idV}",name="pdfShow", methods={"GET"})
     */
    public function pdfShow( video $video ):Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();

        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);


        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('video_back/pdfVShow.html.twig', [

            'video' => $video
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
     * @Route("/stat", name="video_back_stat", methods={"GET","POST"})
     */
    public function Stat(VideoRepository $videoRepository): Response
    {
        $x = json_encode($videoRepository->getTitres());
        $x = str_replace(',{"titre":',',',$x);
        $x = str_replace('{"titre":','',$x);
        $labels = str_replace('}','',$x);

        $y = json_encode($videoRepository->getLikes());
        $y = str_replace(',{"nbLikes":',',',$y);
        $y = str_replace('{"nbLikes":','',$y);
        $likes = str_replace('}','',$y);

        $y = json_encode($videoRepository->getDislikes());
        $y = str_replace(',{"nbDislikes":',',',$y);
        $y = str_replace('{"nbDislikes":','',$y);
        $dislikes = str_replace('}','',$y);

        return $this->render('video_back/stat.html.twig', [
            'labels' => $labels,'likes' => $likes, 'dislikes' => $dislikes
        ]);
    }

    /**
     * @Route("/", name="video_back_index", methods={"GET"})
     */
    public function index(VideoRepository $videoRepository): Response
    {
        return $this->render('video_back/index.html.twig', [
            'videos' => $videoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="video_back_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $video = new Video();
        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($video);
            $entityManager->flush();

            return $this->redirectToRoute('video_back_index');
        }

        return $this->render('video_back/new.html.twig', [
            'video' => $video,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idV}", name="video_back_show", methods={"GET"})
     */
    public function show(Video $video): Response
    {
        return $this->render('video_back/show.html.twig', [
            'video' => $video,
        ]);
    }

    /**
     * @Route("/{idV}/edit", name="video_back_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Video $video): Response
    {
        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('video_back_index');
        }

        return $this->render('video_back/edit.html.twig', [
            'video' => $video,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idV}", name="video_back_delete", methods={"POST"})
     */
    public function delete(Request $request, Video $video): Response
    {
        if ($this->isCsrfTokenValid('delete'.$video->getIdV(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($video);
            $entityManager->flush();
        }

        return $this->redirectToRoute('video_back_index');
    }
}

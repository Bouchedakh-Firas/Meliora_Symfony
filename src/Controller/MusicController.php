<?php

namespace App\Controller;

use App\Form\Musique1Type;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MusiqueRepository;
use App\Entity\Musique;

/**
 * @Route("/music")
 */
class MusicController extends AbstractController
{

    /**
     * @return Response
     * @Route("/pdf",name="pdfM", methods={"GET"})
     */
    public function pdf(MusiqueRepository $repform ):Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();

        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);


        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('music/pdf.html.twig', [
            $musiques =$repform->findAll(),
            'musiques' => $musiques
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("MusiquesListe.pdf", [
            "Attachment" => true
        ]);
        return new Response('', 200, [
            'Content-Type' => 'application/pdf',
        ]);

    }

    /**
     * @return Response
     * @Route("/pdf/{nombre}",name="pdfMShow", methods={"GET"})
     */
    public function pdfShow( Musique $musique ):Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();

        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);


        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('music/pdfMShow.html.twig', [

            'musique' => $musique
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
     * @Route("/", name="music_index", methods={"GET"})
     */
    public function index(Request $request,MusiqueRepository $musiqueRepository): Response
{
    $requestString=$request->get('searchValue');
    $triString=$request->get('triBy');
    if($requestString != null)
        $musiques = $musiqueRepository->trouverRegimeparID($requestString);
    elseif ($triString != null)
        $musiques = $musiqueRepository->findBy([],[$triString => 'ASC']);
    else
        $musiques = $musiqueRepository->findAll();
    return $this->render('music/x.html.twig', ['musiques' => $musiques]);
}
    /**
     * @Route("/new", name="music_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $musique = new Musique();
        $form = $this->createForm(Musique1Type::class, $musique);
        $form->handleRequest($request); //generer le formulaire

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $imageFile = $form->get('image')->getData();
            $musicFile = $form->get('musicpath')->getData();
            $entityManager->persist($musique);
            if($imageFile && $musicFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename .'.'. $imageFile->guessExtension();
                $musique->setImage($newFilename);
                $originalFilename = pathinfo($musicFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename .'.'. $musicFile->guessExtension();
                $musique->setMusicpath($newFilename);
                $entityManager->flush();
            }

            return $this->redirectToRoute('music_index');
        }

        return $this->render('music/new.html.twig', [
            'musique' => $musique,
            'form' => $form->createView(),
        ]);
    }

//    /**
//     * @Route("/{nombre}", name="music_show", methods={"GET"})
//     */
//    public function show(Musique $musique): Response
//    {
//        return $this->render('music/show.html.twig', [
//            'musique' => $musique,
//        ]);
//    }

    /**
     * @Route("/{nombre}/edit", name="music_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Musique $musique): Response
    {
        $form = $this->createForm(Musique1Type::class, $musique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('music_index');
        }

        return $this->render('music/edit.html.twig', [
            'musique' => $musique,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{nombre}", name="music_delete", methods={"POST"})
     */
    public function delete(Request $request, Musique $musique): Response
    {
        if ($this->isCsrfTokenValid('delete' . $musique->getNombre(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($musique);
            $entityManager->flush();
        }

        return $this->redirectToRoute('music_index');
    }





}

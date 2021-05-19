<?php

namespace App\Controller;

use App\Entity\Video;
use App\Form\VideoType;
use App\Repository\VideoRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * @Route("/video/back")
 */
class VideoBackController extends AbstractController
{
     /**
     * @Route("/AllVideos", name="AllVideos")
     */
    public function AllVideos(NormalizerInterface $normalizer , VideoRepository $VideoRepository)
    {

        $videos= $VideoRepository ->findAll();
        $jsonContent = $normalizer -> normalize($videos ,'json',['groups '=>'Video:read']);
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/AllVideos/search={value}", name="SearchVideo")
     */
    public function SearchVideo($value,NormalizerInterface $normalizer , VideoRepository  $videoRepository)
    {
        $videos = $videoRepository-> findBytitre($value);
        $jsonContent = $normalizer -> normalize($videos ,'json',['groups '=>'Video:read']);
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/AllVideos/tri={value}", name="TriVideo")
     */
    public function TriVideo($value,NormalizerInterface $normalizer , VideoRepository  $videoRepository)
    {
        $videos = $videoRepository->findBy([],[$value => 'ASC']);
        $jsonContent = $normalizer -> normalize($videos ,'json',['groups '=>'Video:read']);
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/AddVideoJSON/new", name="AddVideoJSON", methods={"GET","POST"})
     */
    public function AddVideoJSON(Request $request,NormalizerInterface $normalizer)
    {
        $videos =new Video();
        $entityManager = $this->getDoctrine()->getManager();
        $videos -> setIdV($request -> get('idV'));
        $videos -> settitre($request -> get('titre'));
        $videos -> setGenre($request -> get('genre'));
        $videos -> setVideopath($request -> get('videopath'));
        $videos -> setThumbnail($request -> get('thumbnail'));
        $videos -> setNbLikes($request -> get('nbLikes'));
        $videos -> setNbDislikes($request -> get('nbDislikes'));
        $videos -> setMailsent($request -> get('mailsent'));
        $entityManager -> persist($videos);
        $entityManager ->flush();
        $jsonContent = $normalizer -> normalize($videos ,'json',['groups '=>'Video:read']);
        return  new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/updateVideoJSON/{id}", name="updateVideoJSON", methods={"GET","POST"})
     */
    public function updateVideoJSON($id,Request $request,NormalizerInterface $normalizer){
        $entityManager = $this->getDoctrine()->getManager();
        $videos = $entityManager->getRepository(Video::class)->find($id);
        $videos -> settitre($request -> get('titre'));
        $videos -> setGenre($request -> get('genre'));
        $videos -> setVideopath($request -> get('videopath'));
        $videos -> setThumbnail($request -> get('thumbnail'));
        $videos -> setNbLikes($request -> get('nbLikes'));
        $videos -> setNbDislikes($request -> get('nbDislikes'));
        $videos -> setMailsent($request -> get('mailsent'));
        $entityManager -> persist($videos);
        $entityManager ->flush();
        $jsonContent = $normalizer -> normalize($videos ,'json',['groups '=>'Video:read']);
        return  new Response("Information update successfully".json_encode($jsonContent));
    }

    /**
     * @Route("/likeVideoJson/{idV}", name="likeVideoJson", methods={"GET","POST"})
     */
    public function likeVideoJson(Video $video,NormalizerInterface $normalizer): Response
    {
        $video->setNbLikes($video->getNbLikes()+1);
        $this->getDoctrine()->getManager()->flush();
        $jsonContent = $normalizer -> normalize($video ,'json',['groups '=>'Video:read']);
        return  new Response("Video liked ! ".json_encode($jsonContent));
    }

    /**
     * @Route("/dislikeVideoJson/{idV}", name="dislikeVideoJson", methods={"GET","POST"})
     */
    public function dislikeVideoJson(Video $video,\Swift_Mailer $mailer,NormalizerInterface $normalizer): Response
    {
        $video->setNbDislikes($video->getNbDislikes()+1);
        $this->getDoctrine()->getManager()->flush();

        if($video->getNbLikes()<$video->getNbDislikes() && $video->getMailsent()==0){
            $message = (new \Swift_Message('Hello Email'))
                ->setFrom('safa.kaabi@esprit.tn')
                ->setTo('ahmed.gontara@esprit.tn')
                ->setSubject('Meliora : Warning !')
                ->setBody(
                    $this->renderView(
                    // templates/emails/registration.html.twig
                        'video_back/mail.html.twig',[
                        'titre'=>$video->getTitre(),'dislikes'=>$video->getNbDislikes()
                    ]),
                    'text/html'
                )
            ;

            if($mailer->send($message)){
                $video->setMailsent(1);
                $this->getDoctrine()->getManager()->flush();
            }
        }

        $jsonContent = $normalizer -> normalize($video ,'json',['groups '=>'Video:read']);
        return  new Response("Video disliked ! ".json_encode($jsonContent));    }

    /**
     * @Route("/deleteVideoJson/{id}", name="deleteVideoJson", methods={"GET","POST"})
     */
    public function deleteVideoJson($id,Request $request,NormalizerInterface $normalizer)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $videos = $entityManager->getRepository(Video::class)->find($id);
        $entityManager -> remove($videos);
        $entityManager ->flush();
        $jsonContent = $normalizer -> normalize($videos ,'json',['groups '=>'Video:read']);
        return  new Response("Video deleted successfully".json_encode($jsonContent));
    }
    /**
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

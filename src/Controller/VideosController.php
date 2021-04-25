<?php

namespace App\Controller;

use App\Entity\Video;
use App\Entity\VLike;
use App\Form\Video1Type;
use App\Repository\UserRepository;
use App\Repository\VideoRepository;
use App\Repository\VLikeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/videos")
 */
class VideosController extends AbstractController
{
    /**
     * @Route("/", name="videos_index", methods={"GET"})
     */
    public function index(VideoRepository $videoRepository): Response
    {
        return $this->render('videos/index.html.twig', [
            'videos' => $videoRepository->findAll(),
        ]);
    }



    /**
     * @Route("/like/{idV}", name="video_like", methods={"GET","POST"})
     */
    public function like(Video $video): Response
    {
        $video->setNbLikes($video->getNbLikes()+1);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('videos_index');
    }

    /**
     * @Route("/dislike/{idV}", name="video_dislike", methods={"GET","POST"})
     */
    public function dislike(Video $video,\Swift_Mailer $mailer): Response
    {
        $video->setNbDislikes($video->getNbDislikes()+1);
        $this->getDoctrine()->getManager()->flush();

        if($video->getNbLikes()<$video->getNbDislikes()){
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

            $mailer->send($message);
        }

        return $this->redirectToRoute('videos_index');
    }


}
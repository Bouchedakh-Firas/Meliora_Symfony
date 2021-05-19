<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CitationsRepository;
use App\Entity\Citations;
use App\Form\CitationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CitationController extends AbstractController
{/**
     * 
     * @Route("/likem", name="likec")
     */
    public function LikerPm(CitationsRepository $repository,Request $request)
    {$id = $request->get('id');
        $citation = $repository->findOneBy(array('id' => $id));
        $i = $citation->getLiker();
        $citation->setLiker($i+1);
        dump($citation);
        $em=$this->getDoctrine()->getManager();
        $em->persist($citation);
        $em->flush();
       
        return $this->json($citation);
    }
    /**
     * 
     * @Route("/dislikem", name="dislikeccc")
     */
    public function DislikerPm(CitationsRepository $repository,Request $request)
    {$id = $request->get('id');
        $citation = $repository->findOneBy(array('id' => $id));
        $i = $citation->getDisliker();
        $citation->setDisliker($i+1);
        dump($citation);
        $em=$this->getDoctrine()->getManager();
        $em->persist($citation);
        $em->flush();
       
        return $this->json($citation);
    }
/**
     *@route("/updatem",name="updatem")
     *method ("PUT")
     */
    public function Updatem( CitationsRepository $repo,Request $request)
    {$id = $request->get('id');
        $citations= $repo->find($id);
        $auteur = $request->get('auteur');
        $text = $request->get('text');
        $genre = $request->get('genre');
        $citations->setAuteur($auteur);
$citations->setText($text);
$citations->setGenre($genre);
            $em=$this->getDoctrine()->getManager();
            $em->persist($citations);
            $em->flush();
            return $this->json($citations); 
         
        }
 /**
 *  @param Request $request
 * @return \Symfony\Component\HttpFoundation\Response
 * @route("/Addm",name="Addmobile")
 * @method ("POST")
 */

function Addm(Request $request)
{
    $citation = new Citations();
    $auteur = $request->query->get('auteur');
    $text = $request->query->get('text');
    $genre = $request->query->get('genre');
$citation->setAuteur($auteur);
$citation->setText($text);
$citation->setGenre($genre);
    $em=$this->getDoctrine()->getManager();
            $em->persist($citation);
            $em->flush();
            return $this->json($citation); 
    
}
 /**
     * @param CitationsRepository $repo
     * @return Response
     * @route("/Affichecm",name="Affichecitationm")
     */
    public function Affichem(CitationsRepository $repo)
    {
        //$repo = $this ->getDoctrine()->getRepository(Citations::class);
        $citations = $repo->findAll();
        //$formatted= $Serializer->normalize($citations);
        return $this->json($citations); 
    }
 /**
      * @param Request $request
     *@route("/sup",name="cc")
     *@method ("DELETE") 
     */
    public function Deletem(CitationsRepository $repo,Request $request)
    { 
        $id = $request->get('id');
        $citations= $repo->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($citations);
        $em->flush();   
        if ($citations != null) {
        $Serializer= new Serializer([new ObjectNormalizer()]);
        $formatted =$Serializer->normalize("citation a ete supprimé");
        return $this->json($formatted);
    }
         return $this->json($citations);
    }
    
    /**
     * @Route("/citation", name="citation")
     */
    public function index(): Response
    {
        return $this->render('citation/index.html.twig', [
            'controller_name' => 'CitationController',
        ]);
    }

    /**
     * @param CitationsRepository $repo
     * @return Response
     * @route("/Affichec",name="Affichec")
     */
    public function Affiche(CitationsRepository $repo)
    {
        //$repo = $this ->getDoctrine()->getRepository(Citations::class);
        $citations = $repo->findAll();
        return $this->render('citation/Affiche.html.twig', [
            'citations' => $citations
        ]);
    }
    /**
     *@route("/de{id}",name="de")
     */
    public function Delete($id, CitationsRepository $repo)
    {

        $citations = $repo->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($citations);
        $em->flush();
        return $this->redirectToRoute('Affichec');
    }
/**
 *  @param Request $request
 * @return \Symfony\Component\HttpFoundation\Response
 * @route("/Add",name="Add")
 */

    function Add(Request $request)
    {
        $citations = new Citations();

        $form = $this->createForm(CitationType::class, $citations);
        $form->add('Ajouter citation',SubmitType::class);
        $form->handleRequest($request);
      
        if($form->isSubmitted() && $form->isValid() )
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($citations);
            $em->flush();
            return $this->redirectToRoute('Affichec');
        }
        return $this->render('citation/Add.html.twig', 
    [
        'form'=>$form->createView()
    ]);
    }
    /**
     *@route("/uc{id}",name="uc")
     */
    public function Update($id, CitationsRepository $repo,Request $request)
    {$citations = $repo->find($id);
        $form = $this->createForm(CitationType::class, $citations);
        $form->add('Modifier citation',SubmitType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() )
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($citations);
            $em->flush();
            return $this->redirectToRoute('Affichec');
        }
        return $this->render('citation/Update.html.twig', 
    [
        'form'=>$form->createView()
    ]);
    }
    /**
     * @Route("/searchcx ", name="searchcx")
     *  @param EBooksRepository $repo
     */
    public function searchCitationx(Request $request,NormalizerInterface $Normalizer)
    {
        /*$repository = $this->getDoctrine()->getRepository(Ebooks::class);
        $requestString=$request->get('searchValue');
        $ebooks = $repository->findz($requestString);
        $jsonContent = $Normalizer->normalize($ebooks, 'json',['groups'=>'ebooks:read']);
        $retour=json_encode($jsonContent);
        return new Response($retour);*/
    
    
            $repository = $this->getDoctrine()->getRepository(Citations::class);
            $requestString=$request->get('searchValue');
            //$students = $repository->findBy(array('nomP' => $requestString));
            $students = $repository->createQueryBuilder('a')
            // Filter by some parameter if you want
            ->where('a.auteur LIKE :nsc')
                ->setParameter('nsc', '%'.$requestString.'%')
                ->getQuery()
                ->getResult();
                $jsonContent = $Normalizer->normalize($students, 'json', ['groups'=>'citations:read']);
                $retour=json_encode($jsonContent);
                return new Response($retour);
      
    }
    /**
     * 
     * @Route("/like{id}", name="like")
     */
    public function LikerP($id, CitationsRepository $repository)
    {
        $citation = $repository->findOneBy(array('id' => $id));
        $i = $citation->getLiker();
        $citation->setLiker($i+1);
        dump($citation);
        $em=$this->getDoctrine()->getManager();
        $em->persist($citation);
        $em->flush();
       
        return $this->redirectToRoute('Affichec');
    }
     /**
     * 
     * @Route("/dislike{id}", name="dislike")
     */
    public function disLikerP($id, CitationsRepository $repository)
    {
        $citation = $repository->findOneBy(array('id' => $id));
        $i = $citation->getDisliker();
        $citation->setDisliker($i+1);
        dump($citation);
        $em=$this->getDoctrine()->getManager();
        $em->persist($citation);
        $em->flush();
       
        return $this->redirectToRoute('Affichec');
    }
}

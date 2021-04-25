<?php

namespace App\Controller;

use App\Entity\Regime;
use App\Form\Regime1Type;
use App\Repository\RegimeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;



/**
 * @Route("/regime")
 */
class RegimeController extends AbstractController
{
    /**
     * @Route("/", name="regime_index", methods={"GET","POST"})
     */
    public function index(Request $request, RegimeRepository $regimeRepository,NormalizerInterface $Normalizer): Response
    {
        $requestString=$request->get('searchValue');
        if($requestString != null)
            $regimes = $regimeRepository->findRegimeparID($requestString);
        else
            $regimes = $regimeRepository->findAll();
        return $this->render('regime/index.html.twig', ['regimes' => $regimes]);
    }
    /**
     * @Route("/ ", name="searchRegime", methods={"GET","POST"})
     *
     */
    public function searchRegime(Request $request,NormalizerInterface $Normalizer): Response
    {
        $repository = $this->getDoctrine()->getRepository(Regime::class);
        $requestString=$request->get('searchValue');
        $regime = $repository->findRegimeparID($requestString);
        $jsonContent = $Normalizer->normalize($regime, 'json',['groups'=>'regime:read']);
        $retour=json_encode($jsonContent);
        return new Response($retour);
    }
    /**
     * @Route("/new", name="regime_new", methods={"GET","POST"})
     */
    public function new(Request $request, FlashyNotifier $flashy): Response
    {
        $regime = new Regime();
        $form = $this->createForm(Regime1Type::class, $regime);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($regime);
            $entityManager->flush();


            $flashy->success('Regime Ajouté!');
            return $this->redirectToRoute('regime_index');
        }

        return $this->render('regime/new.html.twig', [
            'regime' => $regime,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idRegime}", name="regime_show", methods={"GET"})
     */
    public function show(Regime $regime): Response
    {
        return $this->render('regime/show.html.twig', [
            'regime' => $regime,
        ]);
    }

    /**
     * @Route("/{idRegime}/edit", name="regime_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Regime $regime, FlashyNotifier $flashy): Response
    {
        $form = $this->createForm(Regime1Type::class, $regime);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();


            return $this->redirectToRoute('regime_index');
        }
        $flashy->success('Regime Modifié!');
        return $this->render('regime/edit.html.twig', [
            'regime' => $regime,
            'form' => $form->createView(),
        ]);

    }


    /**
     * @Route("/{idRegime}", name="regime_delete", methods={"POST"})
     */
    public function delete(Request $request, Regime $regime): Response
    {
        if ($this->isCsrfTokenValid('delete'.$regime->getIdRegime(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($regime);
            $entityManager->flush();
        }
        return $this->redirectToRoute('regime_index');
    }







//    /**
//     * @Route("/searchhAction ", name="searchhAction", methods={"GET"})
//     */
//    public function searchhAction(Request $request): Response
//    {
//        $em = $this->getDoctrine()->getManager();
//        $libelle = $request->get('q');
//        $rec = $em->getRepository(Regime::class)->SearchOffre($libelle);
//
//        if (!$rec) {
//            $result['offre']['error'] = "Offer does not exist 🙁 ";
//        } else {
//            $result['offre'] = $this->getRealEntities($rec);
//        }
//        return new Response(json_encode($result));
//    }
//
//    public function getRealEntities($rec)
//    {
//        foreach ($rec as $rec) {
//            $realEntities[$rec->getIdRegime()] = [$rec->getDescription(), $rec->getDuration()];
//
//        }
//        return $realEntities;
//    }
}

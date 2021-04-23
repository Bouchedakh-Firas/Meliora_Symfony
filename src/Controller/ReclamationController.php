<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reclamation")
 */
class ReclamationController extends AbstractController
{
    /**
     * @Route("/", name="reclamation_index", methods={"GET"})
     */
    public function index(ReclamationRepository $reclamationRepository): Response
    {
        return $this->render('reclamation/index.html.twig', [
            'reclamations' => $reclamationRepository->findBy(array('idClient' => $this->getUser())),
        ]);
    }

    /**
     * @Route("/admin/reclamation", name="reclamation_admin", methods={"GET"})
     */
    public function indexAdmin(ReclamationRepository $reclamationRepository): Response
    {
        return $this->render('reclamation/indexAdmin.html.twig', [
            'reclamations' => $reclamationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="reclamation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamation->setIdClient($this->getUser());
            $reclamation->setStatu("non traité");
            $reclamation->setDatereclamation(new \DateTime);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reclamation);
            $entityManager->flush();

            return $this->redirectToRoute('reclamation_index');
        }

        return $this->render('reclamation/new.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reclamation_show", methods={"GET"})
     */
    public function show(Reclamation $reclamation): Response
    {
        return $this->render('reclamation/show.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="reclamation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Reclamation $reclamation): Response
    {
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reclamation_index');
        }

        return $this->render('reclamation/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="reclamation_delete")
     */
    public function delete(Request $request, Reclamation $reclamation): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($reclamation);
        $entityManager->flush();


        return $this->redirectToRoute('reclamation_index');
    }


    /**
     * @Route("/traite/{id}", name="traite", methods={"GET"})
     */
    public function traiteeclamation(ReclamationRepository $reclamationRepository, $id,\Swift_Mailer $mailer): Response
    {
        $reclamation = $this->getDoctrine()->getRepository(Reclamation::class)->find($id);
        $reclamation->setStatu('Traité');
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($reclamation);
        $entityManager->flush();

        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('projetpidev992@gmail.com')
            ->setTo($reclamation->getIdClient()->getEmail())
            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'Reclamation/emailsTraite.html.twig',
                    ['reclamation' => $reclamation ]
                ),
                'text/html'
            );
        $mailer->send($message);
        return $this->redirectToRoute('reclamation_admin');


    }


    /**
     * @Route("/archive/{id}", name="archive", methods={"GET"})
     */
    public function archiveReclamation(ReclamationRepository $reclamationRepository, $id): Response
    {
        $reclamation = $this->getDoctrine()->getRepository(Reclamation::class)->find($id);
        $reclamation->setStatu('archivé');
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($reclamation);
        $entityManager->flush();
        return $this->redirectToRoute('reclamation_admin');


    }
}
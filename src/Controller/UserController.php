<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\User1Type;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** @Route("/user") */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user")
     */
    public function index( UserRepository  $userRepository): Response
    {
        return $this->render('user/AllUser.html.twig', [
            'hotels' => $userRepository->findAll(),
        ]);    }


    /**
     * @Route("/edit", name="profil", methods={"GET","POST"})
     */
    public function edit(Request $request): Response
    {
        $user=$this->getUser();
        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('profil');
        }

        return $this->render('user/show.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }




}

<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Coach2Controller extends AbstractController
{
    /**
     * @Route("/coach2", name="coach2")
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('coach2/index.html.twig', [
            'controller_name' => 'Coach2Controller',
        ]);
    }
}


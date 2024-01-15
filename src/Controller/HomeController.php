<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/entete', name: 'app_entete')]
    public function entete(): Response
    {

        return $this->render('home/entete.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/menu', name: 'app_menu')]
    public function menu(): Response
    {
        return $this->render('home/menu.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}

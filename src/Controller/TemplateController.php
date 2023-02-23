<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TemplateController extends AbstractController
{
    #[Route('/dashboard', name: 'app_template_admin')]
    public function dashboard_index(): Response
    {
        return $this->render('base1.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }

    #[Route('/home', name: 'app_template')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }
}

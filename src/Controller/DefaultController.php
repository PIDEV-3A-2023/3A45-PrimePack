<?php

namespace App\Controller;

use Cassandra\Cluster\Builder;
use Endroid\QrCode\Builder\BuilderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/default', name: 'app_default')]
    public function index(BuilderInterface $qrBuilder): Response
    {
        $qrResult = $qrBuilder
        ->size(400)
        ->margin(20)
        ->build();
        $base64 = $qrResult ->getDataUri();

        $html =  '<h1>Latte and codea</h1>';

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
}

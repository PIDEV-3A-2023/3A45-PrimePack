<?php

namespace App\Controller;

use App\dto\Pie;
use App\Repository\AnimalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TemplateController extends AbstractController
{
    #[Route('/dashboard', name: 'app_template_admin')]
    public function dashboard_index(AnimalRepository $animalRepository): Response
    {
        $results= $animalRepository->chartRepository();
        $totalCount = array_reduce($results, function($carry, $result) {
            return $carry + $result['count'];
        }, 0);
        $resultArray = [];
        foreach ($results as $result) {
            $percentage = round(($result['count'] / $totalCount) * 100);
            $obj = new Pie();
            $obj->value = $result['race'];
            $obj->valeur = $percentage ;
            $resultArray[] = $obj;
        }


        return $this->render('base1.html.twig', [
            'controller_name' => 'TemplateController',
            'results'=>$resultArray,
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

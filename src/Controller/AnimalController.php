<?php

namespace App\Controller;

use App\dto\Pie;
use App\Entity\Animal;
use App\Form\AnimalType;
use App\Repository\AnimalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;






#[Route('/animal')]
class AnimalController extends AbstractController
{
    #[Route('/', name: 'app_animal_index', methods: ['GET'])]
    public function index(AnimalRepository $animalRepository): Response
    {
        return $this->render('animal/index.html.twig', [
            'animals' => $animalRepository->findAll(),
        ]);
    }
    #[Route('/{id}/edit', name: 'app_animal_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Animal $animal, AnimalRepository $animalRepository): Response
    {
        $form = $this->createForm(AnimalType::class, $animal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $animalRepository->save($animal, true);

            return $this->redirectToRoute('app_animal_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('animal/edit.html.twig', [
            'animal' => $animal,
            'form' => $form,
        ]);
    }

    #[Route('/chart', name: 'app_chart', methods: ['GET'])]
    public function barChartAction( AnimalRepository $animalRepository  )
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


        return $this->render('base1.html.twig', array(
            'results'  =>  $resultArray,


        ));
    }




    #[Route('/new', name: 'app_animal_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AnimalRepository $animalRepository): Response
    {
        $animal = new Animal();
        $form = $this->createForm(AnimalType::class, $animal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $animalRepository->save($animal, true);

            return $this->redirectToRoute('app_animal_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('animal/new.html.twig', [
            'animal' => $animal,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_animal_show', methods: ['GET'])]
    public function show(Animal $animal): Response
    {
        return $this->render('animal/show.html.twig', [
            'animal' => $animal,
        ]);
    }



    #[Route('/{id}', name: 'app_animal_delete', methods: ['POST'])]
    public function delete(Request $request, Animal $animal, AnimalRepository $animalRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$animal->getId(), $request->request->get('_token'))) {
            $animalRepository->remove($animal, true);
        }

        return $this->redirectToRoute('app_animal_index', [], Response::HTTP_SEE_OTHER);
    }




    #[Route('/anima/search', name: 'animal_search' )]
    public function searchAction(Request $request,EntityManagerInterface $em)
    {

        $requestString = $request->get('q');
        $animals =  $em->getRepository(Animal::class)->findEntitiesByString($requestString);

        if(!count($animals)) {
            $result['animals']['error'] = "Aucun animal trouvé  ";
        } else {
            $result['animals'] = $this->getRealEntities($animals);

        }

        return new Response(json_encode($result));
    }
    public function getRealEntities($animals){
        foreach ($animals as $animal){
            $realEntities[$animal->getId()] = [$animal->getNom(),$animal->getRace()];

        }
        return $realEntities;
    }


}

<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\Evenement1Type;
use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


#[Route('/mobile/evenemennt')]
class EvenemenntMobileController extends AbstractController
{
    #[Route('/futre', name: 'app_evenemennt_front_index_mobile', methods: ['GET'])]
    public function index(EvenementRepository $evenementRepository, NormalizerInterface $normalizable): Response
    {

        $evenemnt = $evenementRepository->getEvfut();
        $jsonContent = $normalizable->normalize($evenemnt, 'json', ['groups' => 'evenement']);
        return new \Symfony\Component\HttpFoundation\JsonResponse($jsonContent);
    }

    #[Route('/past', name: 'app_evenemennt_front_index_past_mobile', methods: ['GET'])]
    public function indexEvnmentHistory(EvenementRepository $evenementRepository, NormalizerInterface $normalizable): Response
    {
        $evenemnt = $evenementRepository->getEvHistory();
        $jsonContent = $normalizable->normalize($evenemnt, 'json', ['groups' => 'evenement']);
        return new \Symfony\Component\HttpFoundation\JsonResponse($jsonContent);

    }

    #[Route('/', name: 'app_evenement_index_mobile', methods: ['GET'])]
    public function indexmain(EvenementRepository $evenementRepository, NormalizerInterface $normalizable): Response
    {
        $evenemnt = $evenementRepository->findAll();
        $jsonContent = $normalizable->normalize($evenemnt, 'json', ['groups' => 'evenement']);
        return new \Symfony\Component\HttpFoundation\JsonResponse($jsonContent);

    }

    #[Route('/new', name: 'app_evenemennt_front_new_mobile', methods: ['GET', 'POST'])]
    public function new(Request $request, EvenementRepository $evenementRepository, \App\Repository\MembreRepository $membreRepository): Response
    {
        $evenement = new Evenement();
        $evenement->setNom($request->get('nom'));
        $evenement->setMembre($membreRepository->findOneById($request->get('idMembre')));
        $evenement->setDescription($request->get('description'));
        $mil = $request->get('date');
        $seconds = $mil / 1000;
        $date = date_create_from_format("d-m-Y h:i:s", date("d-m-Y h:i:s", $seconds));
        $evenement->setDate($date);
        $evenement->setSponsor($request->get('sponsor'));
        $evenement->setNbPlace($request->get('nbPlace'));
        $evenementRepository->save($evenement, true);
        return new \Symfony\Component\HttpFoundation\JsonResponse("sucess");


    }

    #[Route('/{id}', name: 'app_evenemennt_front_delete_mobile', methods: ['POST'])]
    public function delete(Request $request, Evenement $evenement, EvenementRepository $evenementRepository): Response
    {
        $evenementRepository->remove($evenement, true);

        return new Response("evenement suprimer avec success", Response::HTTP_OK);
    }
}

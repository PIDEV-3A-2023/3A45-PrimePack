<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\Evenement1Type;
use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/evenemenntFront')]
class EvenemenntFrontController extends AbstractController
{
    #[Route('/', name: 'app_evenemennt_front_index', methods: ['GET'])]
    public function index(EvenementRepository $evenementRepository): Response
    {

        return $this->render('evenemennt_front/index.html.twig', [
            'evenements' => $evenementRepository->getEvfut(),
        ]);
    }
    #[Route('/past', name: 'app_evenemennt_front_index_past', methods: ['GET'])]
    public function indexEvnmentHistory(EvenementRepository $evenementRepository): Response
    {
        return $this->render('evenemennt_front/indexHistorique.html.twig', [
            'evenements' => $evenementRepository->getEvHistory(),
        ]);
    }

    #[Route('/new', name: 'app_evenemennt_front_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EvenementRepository $evenementRepository): Response
    {
        $evenement = new Evenement();
        $form = $this->createForm(Evenement1Type::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $evenementRepository->save($evenement, true);

            return $this->redirectToRoute('app_evenemennt_front_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('evenemennt_front/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_evenemennt_front_show', methods: ['GET'])]
    public function show(Evenement $evenement): Response
    {
        return $this->render('evenemennt_front/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_evenemennt_front_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Evenement $evenement, EvenementRepository $evenementRepository): Response
    {
        $form = $this->createForm(Evenement1Type::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $evenementRepository->save($evenement, true);

            return $this->redirectToRoute('app_evenemennt_front_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('evenemennt_front/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_evenemennt_front_delete', methods: ['POST'])]
    public function delete(Request $request, Evenement $evenement, EvenementRepository $evenementRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evenement->getId(), $request->request->get('_token'))) {
            $evenementRepository->remove($evenement, true);
        }

        return $this->redirectToRoute('app_evenemennt_front_index', [], Response::HTTP_SEE_OTHER);
    }
}

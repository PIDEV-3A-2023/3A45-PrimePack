<?php

namespace App\Controller;

use App\Entity\Actualite;
use App\Form\ActualiteType;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\ActualiteRepository;
use App\Repository\CommentaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/actualite')]
class ActualiteController extends AbstractController
{
    #[Route('/', name: 'app_actualite_index', methods: ['GET'])]
    public function index(ActualiteRepository $actualiteRepository): Response
    {
        return $this->render('actualite/index.html.twig', [
            'actualites' => $actualiteRepository->findAll(),
        ]);
    }
    #[Route('/actu', name: 'app_actualite_affiche', methods: ['GET'])]
    public function aff(ActualiteRepository $ActualiteRepository): Response
    {
        return $this->render('actualite/afficher.html.twig', [
            'actualites' => $ActualiteRepository->findAll(),
        ]);
    }
    

    #[Route('/new', name: 'app_actualite_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ActualiteRepository $actualiteRepository): Response
    {
        $actualite = new Actualite();
        $form = $this->createForm(ActualiteType::class, $actualite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $actualiteRepository->save($actualite, true);

         return $this->redirectToRoute('app_actualite_affiche', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('actualite/new.html.twig', [
            'actualite' => $actualite,
            'form' => $form,
        ]);
    }

    #[Route('act/{id}', name: 'app_actualite_show', methods: ['GET'])]
    public function show(Actualite $actualite): Response
    {
        return $this->render('actualite/show.html.twig', [
            'actualite' => $actualite,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_actualite_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Actualite $actualite, ActualiteRepository $actualiteRepository): Response
    {
        $form = $this->createForm(ActualiteType::class, $actualite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $actualiteRepository->save($actualite, true);

            return $this->redirectToRoute('app_actualite_affiche', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('actualite/edit.html.twig', [
            'actualite' => $actualite,
            'form' => $form,
        ]);
    }
    #[Route('actualite/{id}', name: 'app_actualite_singlepage', methods: ['GET','POST'])]
    public function singlepage(Actualite $AR,ActualiteRepository $AcRepository,Request $request, CommentaireRepository $commentaireRepository): Response
    {
        $commentaire = new Commentaire();
        $commentaire -> setActualite($AR);
        $commentaire->setDate(new \DateTime());
  
        $formC = $this->createForm(CommentaireType::class, $commentaire);
        $formC->handleRequest($request);
        if ($formC->isSubmitted() && $formC->isValid()) {
            $commentaireRepository->save($commentaire, true);
            return $this->redirectToRoute('app_actualite_singlepage', ['id' => $AR->getId()], Response::HTTP_SEE_OTHER);
        }
        return $this->render('actualite/singlepage.html.twig', [
            'ac' => $AR,
            'actualites' => $AcRepository->findAll(),
            'commentaire' => $commentaire,
            'formC' => $formC->createView(),
        ]);
    }
  
    #[Route('/{id}', name: 'app_actualite_delete', methods: ['POST'])]
    public function delete(Request $request, Actualite $actualite, ActualiteRepository $actualiteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$actualite->getId(), $request->request->get('_token'))) {
            $actualiteRepository->remove($actualite, true);
        }

        return $this->redirectToRoute('app_actualite_affiche', [], Response::HTTP_SEE_OTHER);
    }
}

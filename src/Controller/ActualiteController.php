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
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpClient\HttpClient;
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
    #[Route('/search', name: 'app_actualite_search', methods: ['GET'])]
   
    public function search(ActualiteRepository $actualiteRepository, Request $request): JsonResponse
    {
        $query = $request->query->get('q');
   
        dump($query);

        $results = [];
        if ($query !== null) {
            $results = $actualiteRepository->createQueryBuilderForSearch($query)->getQuery()->getResult();
        }
    
        $response = [];
        foreach ($results as $result) {
            $response[] = [
                'url' => $this->generateUrl('app_actualite_singlepage', ['id' => $result->getId()]),
                'theme' => $result->getTheme(),
            ];
        }
    
        return new JsonResponse($response);
    }
     
    #[Route('/stats', name: 'app_stats')]
    public function stats(ActualiteRepository $ActualiteRepository): Response
    {
        $stats = $ActualiteRepository->getCommentsStats();

        $data = [];
        $data[] = ['Post', 'Number of Comments'];

        foreach ($stats as $acStats) {
            $data[] = [$acStats['theme'], $acStats['commentsCount']];
        }

        return $this->render('actualite/stats.html.twig', [
            'chartData' => json_encode($data),
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
      
        $formC = $this->createForm(CommentaireType::class, $commentaire);
        $formC->handleRequest($request);
     
        $httpClient = HttpClient::create();
        
        if ($formC->isSubmitted() && $formC->isValid() ) {
            $commentaire ->setActualite($AR);
                         $commentaire->setDate(new \DateTime());
                        $commentaireRepository->save($commentaire, true);
            $commentaireRepository->save($commentaire, true);
            //filter for bad words:
        //     $content = $commentaire->getText();
        //     $response = $httpClient->request('GET', 'https://neutrinoapi.net/bad-word-filter', [
        //         'query' => [
        //             'content' => $content
        //         ],
        //         'headers' => [
        //             'User-ID' => 'ysf',
        //             'API-Key' => 'y1sHojwhnPNtbeRwYt90l6nUiluLvAP6WUfH4cHDjoeMCRj2',
                   
        //         ]
        //     ]);
        //     if ($response->getStatusCode() === 200) {
        //         $result = $response->toArray();
        //         if ($result['is-bad']) {
        //             // Handle bad word found

        //             return $this->redirectToRoute('app_actualite_singlepage', ['id' => $AR->getId()], Response::HTTP_SEE_OTHER);
        //         } else {
        //             // Save comment
        //             $commentaire ->setActualite($AR);
        //             $commentaire->setDate(new \DateTime());
        //             $commentaireRepository->save($commentaire, true);
                  
        //             return $this->redirectToRoute('app_actualite_singlepage', ['id' => $AR->getId()], Response::HTTP_SEE_OTHER);
        //         }
        //     } else {
        //         // Handle API error
                
        //         return new Response("Error processing request", Response::HTTP_INTERNAL_SERVER_ERROR);
        //     } 
           
        }

        $url = $this->generateUrl('app_actualite_singlepage', ['id' => $AR->getId()], UrlGeneratorInterface::ABSOLUTE_URL);
        return $this->render('actualite/singlepage.html.twig', [
            'ac' => $AR,
            'actualites' => $AcRepository->findAll(),
            'commentaire' => $commentaire,
            'formC' => $formC->createView(),
            'share_url' => $url,
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

<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\Ticket2Type;
use App\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Stripe\Checkout\Session;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;


use Stripe\Stripe;

#[Route('/ticketFront')]
class TicketFrontController extends AbstractController
{
    #[Route('/', name: 'app_ticket_front_index', methods: ['GET'])]
    public function index(TicketRepository $ticketRepository, \App\Repository\MembreRepository $membreRepository, \App\Repository\EvenementRepository $evenementRepository): Response
    {
        $tickets = $ticketRepository->findBy(['membre' => $membreRepository->findOneById(2)]);


        return $this->render('ticket_front/index.html.twig', [
            'tickets' => $tickets,
            'date' => new \DateTime(),
            'tri' => 'DESC'
        ]);
    }

    #[Route('/triEvnment/{tri}', name: 'app_ticket_index_tri_date', methods: ['GET'])]
    public function index1($tri, TicketRepository $ticketRepository, \App\Repository\MembreRepository $membreRepository): Response
    {
        $tickets = $ticketRepository->findBy(array('membre' => $membreRepository->findOneById(2)), array('date_debut' => $tri));
        if ($tri == 'DESC') {
            $tri = 'ASC';
        } else {
            $tri = 'DESC';
        }

        return $this->render('ticket_front/index.html.twig', [
            'tickets' => $tickets,
            'date' => new \DateTime(),
            'tri' => $tri
        ]);

    }

    #[Route('/exel', name: 'app_ticket_exel', methods: ['GET'])]
    public function indexexel(TicketRepository $ticketRepository, \App\Repository\MembreRepository $membreRepository): Response
    {
        $tickets = $ticketRepository->findBy(['membre' => $membreRepository->findOneById(2)]);

        $path = 'C:\exel\tikets.xlsx';
        $writer = WriterEntityFactory::createXLSXWriter();
        $writer->openToFile($path);
        $header = ['id', 'code', 'prix', 'nom_evenement'];
        $rowFromValues = WriterEntityFactory::createRowFromArray($header);
        $writer->addRow($rowFromValues);
        foreach ($tickets as $row) {
            $tiket = ['id' => $row->getId(), 'code' => $row->getCode(), 'prix' => $row->getPrix(), 'nom_evenement' => $row->getEvenement()->getNom()];

            $rowFromValues = WriterEntityFactory::createRowFromArray($tiket);
            $writer->addRow($rowFromValues);
        }
        $writer->close();
        $this->addFlash('success', 'Exel sheet is ready check ' . $path);
        return $this->redirectToRoute('app_ticket_front_index', [], Response::HTTP_SEE_OTHER);

    }

    #[Route('/new/{idE}', name: 'app_ticket_front_new', methods: ['GET', 'POST'])]
    public function new($idE, Request $request, TicketRepository $ticketRepository, \App\Repository\EvenementRepository $evenementRepository, \App\Repository\MembreRepository $membreRepository): Response
    {
        $ticket = new Ticket();
        $form = $this->createForm(Ticket2Type::class, $ticket);
        $form->handleRequest($request);
        $ticket->setDateDebut(new \DateTime());
        $ticket->setDateFin(new \DateTime());
        if ($form->isSubmitted() && $form->isValid()) {


            $ticket->setPrix($ticket->nbJour * 10);
            $ev = $evenementRepository->findOneById($idE);
            $ticket->setEvenement($ev);
            $ticket->setMembre($membreRepository->findOneById(2));
            $ticketRepository->save($ticket, true);

            $this->addFlash('success', 'ticket reservation succée');


            Stripe::setApiKey('sk_test_51HnVLcL83IQ8H8DrwhPGzj69I35Pj4kT5Ha3L0OiU2V3Rq3yatCybhyndI09PRuezGocFKvQPTjSE0TbmxTpxKKJ00duZqdBmt');
            $nomEv = $ev->getNom();
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'eur',
                            'product_data' => [
                                'name' => "$nomEv",
                            ],
                            'unit_amount' => $ticket->nbJour * 10 * 100,
                        ],
                        'quantity' => 1,
                    ]
                ],
                'mode' => 'payment',
                'success_url' => $this->generateUrl('app_ticket_front_index', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'cancel_url' => $this->generateUrl('app_ticket_front_new', ['idE' => $ev->getId()], UrlGeneratorInterface::ABSOLUTE_URL),
            ]);

            return $this->redirect($session->url, 303);
        }

        return $this->renderForm('ticket_front/new.html.twig', [
            'ticket' => $ticket,
            'form' => $form,
        ]);
    }

//    #[Route('/{id}', name: 'app_ticket_front_show', methods: ['GET'])]
//    public function show(Ticket $ticket): Response
//    {
//        return $this->render('ticket_front/show.html.twig', [
//            'ticket' => $ticket,
//        ]);
//    }

    #[Route('/{id}/edit', name: 'app_ticket_front_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ticket $ticket, TicketRepository $ticketRepository): Response
    {
        $form = $this->createForm(Ticket2Type::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ticketRepository->save($ticket, true);

            return $this->redirectToRoute('app_ticket_front_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ticket_front/edit.html.twig', [
            'ticket' => $ticket,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ticket_front_delete', methods: ['POST'])]
    public function delete(Request $request, Ticket $ticket, TicketRepository $ticketRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $ticket->getId(), $request->request->get('_token'))) {
            $ticketRepository->remove($ticket, true);
        }

        return $this->redirectToRoute('app_ticket_front_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/codeqr/{id}', name: 'app_ticket_codeqr', methods: ['GET'])]
    public function codeqr(Request $request, Ticket $ticket, TicketRepository $ticketRepository): Response
    {
        return $this->render('ticket_front/codeqr.html.twig', [
            'ticket' => $ticket
        ]);
    }
}

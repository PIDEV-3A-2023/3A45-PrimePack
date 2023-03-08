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
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


use Stripe\Stripe;

#[Route('/mobile/ticket')]
class TicketMobileController extends AbstractController
{
    #[Route('/', name: 'app_ticket_front_index_mobile', methods: ['GET'])]
    public function index(TicketRepository $ticketRepository, \App\Repository\MembreRepository $membreRepository, NormalizerInterface $normalizable): Response
    {

        $tickets = $ticketRepository->findAll();
        $jsonContent = $normalizable->normalize($tickets, 'json', ['groups' => 'ticket']);
        return new \Symfony\Component\HttpFoundation\JsonResponse($jsonContent);
    }

    #[Route('/mes', name: 'app_ticket_front_index_mobile', methods: ['GET'])]
    public function index1(TicketRepository $ticketRepository, \App\Repository\MembreRepository $membreRepository, NormalizerInterface $normalizable): Response
    {

        $tickets = $ticketRepository->findBy(['membre' => $membreRepository->findOneById(2)]);
        $jsonContent = $normalizable->normalize($tickets, 'json', ['groups' => 'ticket']);
        return new \Symfony\Component\HttpFoundation\JsonResponse($jsonContent);
    }

//    #[Route('/triEvnment/{tri}', name: 'app_ticket_index_tri_date', methods: ['GET'])]
//    public function index1($tri, TicketRepository $ticketRepository, \App\Repository\MembreRepository $membreRepository): Response
//    {
//        $tickets = $ticketRepository->findBy(array('membre' => $membreRepository->findOneById(2)), array('date_debut' => $tri));
//        if ($tri == 'DESC') {
//            $tri = 'ASC';
//        } else {
//            $tri = 'DESC';
//        }
//
//        return $this->render('ticket_front/index.html.twig', [
//            'tickets' => $tickets,
//            'date' => new \DateTime(),
//            'tri' => $tri
//        ]);
//
//    }

//    #[Route('/exel', name: 'app_ticket_exel', methods: ['GET'])]
//    public function indexexel(TicketRepository $ticketRepository, \App\Repository\MembreRepository $membreRepository): Response
//    {
//        $tickets = $ticketRepository->findBy(['membre' => $membreRepository->findOneById(2)]);
//
//        $path = 'E:\tikets.xlsx';
//        $writer = WriterEntityFactory::createXLSXWriter();
//        $writer->openToFile($path);
//        $header = ['id', 'code', 'prix', 'nom_evenement'];
//        $rowFromValues = WriterEntityFactory::createRowFromArray($header);
//        $writer->addRow($rowFromValues);
//        foreach ($tickets as $row) {
//            $tiket = ['id' => $row->getId(), 'code' => $row->getCode(), 'prix' => $row->getPrix(), 'nom_evenement' => $row->getEvenement()->getNom()];
//
//            $rowFromValues = WriterEntityFactory::createRowFromArray($tiket);
//            $writer->addRow($rowFromValues);
//        }
//        $writer->close();
//        $this->addFlash('success', 'Exel sheet is ready check ' . $path);
//        return $this->redirectToRoute('app_ticket_front_index', [], Response::HTTP_SEE_OTHER);
//
//    }

    #[Route('/new/{idE}', name: 'app_ticket_front_new_mobile', methods: ['GET', 'POST'])]
    public function new($idE, Request $request, TicketRepository $ticketRepository, \App\Repository\EvenementRepository $evenementRepository, \App\Repository\MembreRepository $membreRepository): Response
    {
        $ticket = new Ticket();
        $ticket->setDateDebut(new \DateTime());
        $ticket->setDateFin(new \DateTime());

        $ticket->setPrix($request->get("nbJour") * 10);
        $ev = $evenementRepository->findOneById($idE);
        $ticket->setEvenement($ev);
        $ticket->setMembre($membreRepository->findOneById(2));
        $ticket->setCode($request->get("code"));
        $ticketRepository->save($ticket, true);

        return new Response("ticket reservation succée", Response::HTTP_OK);


    }


    #[Route('/{id}', name: 'app_ticket_front_delete_mobile', methods: ['POST'])]
    public function delete(Request $request, Ticket $ticket, TicketRepository $ticketRepository): Response
    {
        $ticketRepository->remove($ticket, true);

        return new Response("ticket delete succée", Response::HTTP_OK);
    }

    #[Route('/codeqr/{id}', name: 'app_ticket_codeqr_mobile', methods: ['GET'])]
    public function codeqr(Request $request, Ticket $ticket, TicketRepository $ticketRepository): Response
    {
        return $this->render('ticket_front/codeqr.html.twig', [
            'ticket' => $ticket
        ]);
    }
}

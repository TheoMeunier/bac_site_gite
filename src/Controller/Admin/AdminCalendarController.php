<?php

namespace App\Controller\Admin;

use App\Entity\Calendar;
use App\Form\CalendarType;
use App\Repository\CalendarRepository;
use App\Repository\GiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/admin", name="admin_")
 */
class AdminCalendarController extends AbstractController
{
    public function __construct(GiteRepository $repository, EntityManagerInterface $em)
    {
        $this->gite = $repository;
        $this->em = $em;

    }

    /**
     * @Route("/calendar", name="reservation", methods={"GET"})
     */
    public function index(CalendarRepository $calendarRepository): Response
    {
        return $this->render('admin/reservation/index.html.twig', [
            'calendars' => $calendarRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="new_reservation", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $calendar = new Calendar();
        $form = $this->createForm(CalendarType::class, $calendar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($calendar);
            $entityManager->flush();

            $this->addFlash('success', 'Votre réservation a bien été crée');
            return $this->redirectToRoute('admin_reservation');
        }

        return $this->render('admin/reservation/new.html.twig', [
            'calendar' => $calendar,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit_reservation", methods={"GET","POST"})
     */
    public function edit(Request $request, Calendar $calendar): Response
    {
        $form = $this->createForm(CalendarType::class, $calendar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Votre réservation a bien été modifier');
            return $this->redirectToRoute('admin_reservation');
        }

        return $this->render('admin/reservation/edit.html.twig', [
            'calendar' => $calendar,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/supprimer_reservation/{id}", name="delete_reservation", methods={"DELETE"})
     */
    public function delete(Request $request, Calendar $calendar): Response
    {
        if ($this->isCsrfTokenValid('delete' . $calendar->getId(), $request->get('_token'))) {

            $this->em->remove($calendar);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Votre réservation a bien été supprimer');

        }

        return $this->redirectToRoute('admin_reservation');
    }
}

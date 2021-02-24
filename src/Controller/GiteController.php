<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Gite;
use App\Form\ContactType;
use App\Repository\GiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GiteController extends AbstractController
{

    /**
     * @Route("/gite", name="gite")
     * @param GiteRepository $gite
     * @return Response
     */
    public function index(GiteRepository $gite): Response
    {
        return $this->render('gite/index.html.twig', [
            'gite' => $gite->findAll(),
        ]);
    }

    /**
     * @Route("/gite/{id}", name="gite_show")
     * @param int $id
     * @param GiteRepository $giteRepository
     * @return Response
     */
    public function show(int $id, Request $request, Gite $gite, GiteRepository $giteRepository): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();

            return $this->redirectToRoute('gite_show', [
                'id' => $gite->getId()
            ]);
        }
        return $this->render('gite/show.html.twig', [
            'gite' => $giteRepository->find($id),
             'form' => $form->createView()
        ]);
    }
}

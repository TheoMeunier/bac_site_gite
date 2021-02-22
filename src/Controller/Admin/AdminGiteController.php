<?php

namespace App\Controller\Admin;

use App\Entity\Gite;
use App\Form\GiteType;
use App\Repository\GiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/admin", name="admin_")
 */
class AdminGiteController extends AbstractController
{

    public function __construct(GiteRepository $repository, EntityManagerInterface $em)
    {
        $this->gite = $repository;
        $this->em = $em;

    }

    /**
     * @Route("/gite", name="gite")
     */
    public function index(GiteRepository $gite): Response
    {
        return $this->render('admin/gite/index.html.twig', [
            'gite' => $gite->findAll(),
        ]);
    }

    /**
     * @Route("/nouveau_gite", name="new_gite")
     */
    public function new(Request $request)
    {
        $gite = new Gite();
        $form = $this->createForm(GiteType::class, $gite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($gite);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'votre category a bien ete crée');
            return $this->redirectToRoute('admin_gite');
        }

        return $this->render('admin/gite/new.html.twig', [
            'gite' => $gite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/modifier_gite/{id}", name="edit_gite", methods={"GET", "POST"}, requirements={"id":"\d+"})
     */
    public function edit(Gite $gite, Request $request): Response
    {
        $form = $this->createForm(GiteType::class, $gite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Votre actircle a bien ete modifier');

            return $this->redirectToRoute('admin_gite');
        }

        return $this->render('admin/gite/edit.html.twig',[
            'gite' => $gite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/supprimer_gite/{id}", name="delete_gite", methods={"DELETE"})
     */
    public function delete(Gite $gite, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $gite->getId(), $request->get('_token'))) {

            $this->em->remove($gite);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Votre actircle a bien ete supprimer');

        }

        return $this->redirectToRoute('admin_gite');
    }
}

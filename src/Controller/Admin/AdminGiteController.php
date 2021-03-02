<?php

namespace App\Controller\Admin;

use App\Entity\Gite;
use App\Entity\ImageGite;
use App\Form\GiteType;
use App\Repository\GiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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

            //on recupere les images transmises
            $images = $form->get('image')->getData();

            // on blouce sur les images
            foreach ($images as $image) {
                //on génère un nouveau nom de fichier
                $ficher = md5(uniqid()) . '.' . $image->guessExtension();
                //on copier le ficher dans le dossier upload
                $image->move(
                    $this->getParameter('images_directory'),
                    $ficher
                );
                //on stock image dans la db
                $img = new ImageGite();
                $img->setName($ficher);
                $gite->addImageGite($img);
            }

            $this->em->persist($gite);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Votre bien a bien été crée');
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

            //on recupere les images transmises
            $images = $form->get('image')->getData();

            // on blouce sur les images
            foreach ($images as $image) {
                //on génère un nouveau nom de fichier
                $ficher = md5(uniqid()) . '.' . $image->guessExtension();
                //on copier le ficher dans le dossier upload
                $image->move(
                    $this->getParameter('images_directory'),
                    $ficher
                );
                //on stock image dans la db
                $img = new ImageGite();
                $img->setName($ficher);
                $gite->addImageGite($img);
            }

            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Votre bien a bien été modifier');

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
            $this->addFlash('success', 'Votre bien a bien été supprimer');

        }

        return $this->redirectToRoute('admin_gite');
    }

    /**
     * @Route("/supprime/image/{id}", name="delete_image", methods={"DELETE"})
     */
    public function deleteImage(ImageGite $image, Request $request)
    {
        $data = json_decode($request->getContent(), true);

        // On vérifie si le token est valide
        if($this->isCsrfTokenValid('delete'.$image->getId(), $data['_token'])){
            // On récupère le nom de l'image
            $nom = $image->getName();
            // On supprime le fichier
            unlink($this->getParameter('images_directory').'/'.$nom);

            // On supprime l'entrée de la base
            $em = $this->getDoctrine()->getManager();
            $em->remove($image);
            $em->flush();

            // On répond en json
            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }
    }
}

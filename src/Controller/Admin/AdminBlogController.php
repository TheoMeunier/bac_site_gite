<?php

namespace App\Controller\Admin;

use App\Entity\Blog;
use App\Entity\ImageBlog;
use App\Form\BlogType;
use App\Repository\BlogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/admin", name="admin_")
 */
class AdminBlogController extends AbstractController
{

    public function __construct(BlogRepository $repository, EntityManagerInterface $em)
    {
        $this->blog = $repository;
        $this->em = $em;

    }

    /**
     * @Route("/blog", name="blog")
     */
    public function index(BlogRepository $blog): Response
    {
        return $this->render('admin/blog/index.html.twig', [
            'blog' => $blog->findAll(),
        ]);
    }

    /**
     * @Route("/nouveau_blog", name="new_blog")
     */
    public function new(Request $request)
    {
        $blog = new Blog();
        $form = $this->createForm(BlogType::class, $blog);
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
                $img = new ImageBlog();
                $img->setName($ficher);
                $blog->addImageBlog($img);
            }

            $this->em->persist($blog);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Votre article a bien ete crée');
            return $this->redirectToRoute('admin_blog');
        }

        return $this->render('admin/blog/new.html.twig', [
            'blog' => $blog,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/modifier_blog/{id}", name="edit_blog", methods={"GET", "POST"}, requirements={"id":"\d+"})
     */
    public function edit(Blog $blog, Request $request): Response
    {
        $form = $this->createForm(BlogType::class, $blog);
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
                $img = new ImageBlog();
                $img->setName($ficher);
                $blog->addImageBlog($img);
            }

            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Votre actircle a bien ete modifier');

            return $this->redirectToRoute('admin_blog');
        }

        return $this->render('admin/blog/edit.html.twig',[
            'blog' => $blog,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/supprimer_blog/{id}", name="delete_blog", methods={"DELETE"})
     */
    public function delete(Blog $blog, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $blog->getId(), $request->get('_token'))) {

            $this->em->remove($blog);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Votre actircle a bien ete supprimer');

        }

        return $this->redirectToRoute('admin_gite');
    }

    /**
     * @Route("/supprime/blog/image/{id}", name="blog_delete_image", methods={"DELETE"})
     */
    public function deleteImage(ImageBlog $image, Request $request)
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

<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Entity\CommentBlog;
use App\Entity\User;
use App\Form\CommentBlogType;
use App\Repository\BlogRepository;
use App\Repository\CommentBlogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(BlogRepository $repository): Response
    {
        return $this->render('blog/index.html.twig', [
            'blog' => $repository->findAll(),
        ]);
    }

    /**
     * @Route("/blog/{id}", name="blog_show")
     */
    public function show(int $id, BlogRepository $repository, Request $request, Blog $blog): Response
    {
        //on recupere l'entity
        $commentaires = new CommentBlog();
        $commentaires->setCommentBlog($blog);

        //on traitre le commentaire
        $form = $this->createForm(CommentBlogType::class, $commentaires);
        $form->handleRequest($request);

        //on persiste les donnée
        if ($form->isSubmitted() && $form->isValid()) {
            //on recupere l'utilisateur
            $repository->findOneBy(['id' => $id]);
            $user = $this->getUser();
            $commentaires->setUser($user);
            
            //on persiste les donner
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commentaires);
            $entityManager->flush();

            //on refait une redirection
            return $this->redirectToRoute('blog_show', [
                'id' => $blog->getId()
            ]);
        }

        return $this->render('blog/show.html.twig', [
            'blog' => $repository->find($id),
            'form' => $form->createView()
        ]);
    }
}

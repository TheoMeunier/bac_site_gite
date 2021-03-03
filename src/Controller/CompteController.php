<?php

namespace App\Controller;

use App\Entity\CommentBlog;
use App\Entity\User;
use App\Form\CommentBlogType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CompteController extends AbstractController
{

    private EntityManagerInterface $em;

    public function __construct( EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/compte/{id}", name="compte")
     */
    public function index(int $id, UserRepository $repository): Response
    {
        return $this->render('compte/index.html.twig', [
            'user' => $repository->find($id),
        ]);
    }

    /**
     * @Route("compte/edit_compte/{id}", name="edit_compte", methods={"GET", "POST"}, requirements={"id":"\d+"})
     */
    public function edit_compte(int $id, CommentBlog $commentBlog, Request $request, UrlGeneratorInterface $generator )
    {
        /** @var  User $user */
        $user = $this->getUser();
        $userid = $user->getId();

        $form = $this->createForm(CommentBlogType::class, $commentBlog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'votre commentaire à bien éte modifier');

            return $this->redirect($generator->generate('compte', ['id' => $userid]));
        }

        return $this->render('compte/edit_message.html.twig',[
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("compte/delete_comment/{id}", name="delete_comment", methods={"DELETE"})
     */
    public function deleteComment(CommentBlog $commentBlog, Request $request, UrlGeneratorInterface $generator)
    {
        /** @var  User $user */
        $user = $this->getUser();
        $userid = $user->getId();

        if ($this->isCsrfTokenValid('delete' .$commentBlog->getId(), $request->get('_token'))) {

            $this->em->remove($commentBlog);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success','votre commentaire à bien éte supprimer');

        }

        return $this->redirect($generator->generate('compte',['id' => $userid]));
    }
}

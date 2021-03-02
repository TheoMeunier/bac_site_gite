<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\EditUserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route ("/admin", name="admin_")
 */
class AdminUserController extends AbstractController
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

    }

    /**
     * @Route("/user", name="user")
     */
    public function index(UserRepository $user): Response
    {
        return $this->render('admin/users/index.html.twig', [
            'user' => $user->findAll()
        ]);
    }


    /**
     * @route ("/utilisateur/modifier/{id}", name="edit_user")
     */
    public function editUser(User $user, Request $request){
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', "L'utilisateur a bien été modfier");
            return $this->redirectToRoute('admin_user');
        }

        return $this->render('admin/users/edit.html.twig', [
            'userFrom' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete_user/{id}", name="delete_user", methods={"DELETE"})
     */
    public function deleteUser(User $user, Request $request)
    {

        if ($this->isCsrfTokenValid('delete' .$user->getId(), $request->get('_token'))){

            $this->em->remove($user);
            $this->em->flush();
        }

        $this->addFlash('success', "L'utilisateur a bien été supprimer");
        return $this->redirectToRoute('admin_user');
    }


}
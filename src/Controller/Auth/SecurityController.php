<?php

namespace App\Controller\Auth;

use App\Entity\User;
use App\Form\ResetPasswordType;
use App\Repository\UserRepository;
use App\Services\MailerServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('auth/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/oublie-pass", name="app_forgotten_password")
     */
    public function forgotten_pass(Request $request, UserRepository $userRepository, MailerServiceInterface $mailer,
                                   TokenGeneratorInterface $tokenGenerator): Response
    {
       //on crée mle formulaire
        $form = $this->createForm(ResetPasswordType::class);
        //on traite le formaulaire
        $form->handleRequest($request);

        //si le formulaire est valide
        if ($form->isSubmitted() && $form->isValid()){
            //on recupere les donnée
            $donnée = $form->getData();

            //on chercher si un utilisateur a cette email
            $user = $userRepository->findOneByEmail($donnée['email']);

            //si l'utilisateur n'existe pas
            if (!$user){
                //on envoye un message flash
                $this->addFlash('danger', "cette adresse n'existe pas");
                return $this->redirectToRoute('app_login');
            }

            //on genere un token
            $token = $tokenGenerator->generateToken();

            try{
                $user->setResetToken($token);
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
            }catch (\Exception $e){
                $this->addFlash('warning', 'Une erreur est survenu');
                return $this->redirectToRoute('app_login');
            }

            //on génere une url
            $url = $this->generateUrl('app_reset_password', ['token' => $token ]);

            //on envoye le message
            $formForget = $this->getParameter('email_noreply');
            $to = $this->getParameter('email');
            $textTemplate = 'auth/email/forgotten_password.html.twig';
            $htmlTemplate = 'auth/email/forgotten_password.html.twig';
            $params = [
                'token'=> $token,
            ];
            $mailer->send($formForget, $to, $textTemplate, $htmlTemplate, $params);
            $this->addFlash('success', 'Un email viens de vous etres envoyer');

           return $this->redirectToRoute('app_login');
        }

        //on envoye vers la page de demande d'email
        return $this->render('auth/forgotten_password.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/reset_pass/{token}", name="app_reset_password")
     */
    public function resetPassword(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder)
    {
        // On cherche un utilisateur avec le token donné
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['reset_token' => $token]);

        // Si l'utilisateur n'existe pas
        if ($user === null) {
            // On affiche une erreur
           $this->addFlash('danger',"Cette utilisateur n'existe pas");
            return $this->redirectToRoute('app_login');
        }

        // Si le formulaire est envoyé en méthode post
        if ($request->isMethod('POST')) {
            // On supprime le token
            $user->setResetToken(null);

            // On chiffre le mot de passe
            $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));

            // On stocke
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // On crée le message flash
            $this->addFlash('success','Mot de passe modifier avec success');

            return $this->redirectToRoute('app_login');
        }else {
            // Si on n'a pas reçu les données, on affiche le formulaire
            return $this->render('auth/reset_password.html.twig', ['token' => $token]);
        }

    }

}

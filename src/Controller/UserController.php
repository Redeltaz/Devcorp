<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Entity\UserLangage;
use App\Form\UserInscriptionType;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/inscription", name="inscription")
     */
    public function inscription(Request $request, User $user = null, UserPasswordEncoderInterface $encoder): Response
    {   
    
        $user = new User;

        $manager = $this->getDoctrine()->getManager();

        $form = $this->createForm(UserInscriptionType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $user->setCreationDate(new \DateTime());
            $user->setPicture("new");
            $user->setGrade(1);
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('connexion');
        }

        return $this->render('user/inscription.html.twig', [
            'inscriptionForm'=> $form->createView()
        ]);
    }


    /**
     * @Route("/connexion", name="connexion")
     */
    public function connexion(Request $request, User $user = null): Response
    {   
    
        $user = new User;
        $manager = $this->getDoctrine()->getManager();

        return $this->render('user/connexion.html.twig', [
            
        ]);
    }


    /**
     * @Route("/deconnexion", name="deconnexion")
     */
    public function logout(): Response
    {
        return $this->render('user/connexion.html.twig');
    }
}

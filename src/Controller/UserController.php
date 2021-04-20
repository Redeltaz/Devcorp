<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Form\UserInscriptionType;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Form\UserImageType;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/profile", name="profile")
     */
    public function profile(Request $request, SluggerInterface $slugger): Response
    {

        $manager = $this->getDoctrine()->getManager();

        $user = $this->getUser();
        $user_posts = $user->getPostes();
        $form = $this->createForm(UserImageType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();

            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $user->getId() . '_' . $user->getPseudo() . '.' . $image->guessExtension();
                $user->setPicture($newFilename);
                $manager->persist($user);
                $manager->flush();
            }

            try {
                $image->move(
                    $this->getParameter('upload_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
            }
        }



        return $this->render('user/profile.html.twig', [
            'user' => $this->getUser(),
            'user_posts' => $user_posts,
            'form' => $form->createView(),
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

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $user->setCreationDate(new \DateTime());
            $user->setPicture('new');
            $user->setGrade(0);
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('connexion');
        }

        return $this->render('user/inscription.html.twig', [
            'inscriptionForm' => $form->createView(),
            'user' => $this->getUser()
        ]);
    }


    /**
     * @Route("profile/edit", name="edit")
     */
    public function editprofile(Request $request): Response
    {


        $user = $this->getUser();
        $manager = $this->getDoctrine()->getManager();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($user);
            $manager->flush();
        }

        return $this->render('user/editprofile.html.twig', [
            'user' => $this->getUser(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/connexion", name="connexion")
     */
    public function connexion(): Response
    {
        return $this->render('user/connexion.html.twig', [
            'user' => $this->getUser()
        ]);
    }


    /**
     * @Route("/deconnexion", name="deconnexion")
     */
    public function logout(): Response
    {
        return $this->render('user/connexion.html.twig', [
            'user' => $this->getUser()
        ]);
    }
}

<?php

namespace App\Controller;

use App\Form\LangageType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\PosteLangage;
use App\Repository\PosteLangageRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $connectedUser = $this->getUser();
        if($connectedUser === null || $connectedUser->getGrade() !== 1){
            return $this->redirectToRoute('home');
        }

        return $this->render('admin/index.html.twig', [
            'user' => $connectedUser
        ]);
    }

    /**
     * @Route("/admin/langage", name="admin_langage")
     */
    public function langages(PosteLangageRepository $repo): Response
    {
        $connectedUser = $this->getUser();
        if($connectedUser === null || $connectedUser->getGrade() !== 1){
            return $this->redirectToRoute('home');
        }

        $langages = $repo->findAll();
        
        return $this->render('admin/langages.html.twig', [
            'langages' => $langages,
            'user' => $connectedUser
        ]);
    }

    /**
     * @Route("/admin/langage/create", name="admin_langage_create")
     * @Route("/admin/langage/modif/{id}", name="admin_langage_modif")
     */
    public function create(Request $request, PosteLangage $poste_langage = null): Response
    {
        $connectedUser = $this->getUser();
        if($connectedUser === null || $connectedUser->getGrade() !== 1){
            return $this->redirectToRoute('home');
        }

        if($poste_langage == null)
        {
            $poste_langage = new PosteLangage;
        }
        $manager = $this->getDoctrine()->getManager();

        $form = $this->createForm(LangageType::class, $poste_langage);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($poste_langage);
            $manager->flush();

            return $this->redirectToRoute('admin_langage');
        }
        
        return $this->render('admin/langageForm.html.twig', [
            'langageForm' => $form->createView(),
            'user' => $connectedUser
        ]);
    }

    /**
     * @Route("/admin/users", name="admin_users")
     */
    public function users(UserRepository $userRepo): Response
    {
        $connectedUser = $this->getUser();
        if($connectedUser === null || $connectedUser->getGrade() !== 1){
            return $this->redirectToRoute('home');
        }

        $allUsers = $userRepo->findAll();

        return $this->render('admin/users.html.twig', [
            'user' => $connectedUser,
            'allUsers' => $allUsers
        ]);
    }

    /**
     * @Route("/admin/ban/{id}", name="admin_ban")
     */
    public function ban($id, UserRepository $userRepo): Response
    {
        $connectedUser = $this->getUser();
        if($connectedUser === null || $connectedUser->getGrade() !== 1){
            return $this->redirectToRoute('home');
        }

        $manager = $this->getDoctrine()->getManager();

        $userToBan = $userRepo->find($id);

        $userToBan->setIsBanished(true);

        $manager->persist($userToBan);
        $manager->flush();

        return $this->redirectToRoute('admin_users', [
            'user' => $connectedUser,
            'allUsers' => $userRepo->findAll()
        ]);
    }

    /**
     * @Route("/admin/unban/{id}", name="admin_unban")
     */
    public function unban($id, UserRepository $userRepo): Response
    {
        $connectedUser = $this->getUser();
        if($connectedUser === null || $connectedUser->getGrade() !== 1){
            return $this->redirectToRoute('home');
        }

        $manager = $this->getDoctrine()->getManager();

        $userToBan = $userRepo->find($id);

        $userToBan->setIsBanished(false);

        $manager->persist($userToBan);
        $manager->flush();

        return $this->redirectToRoute('admin_users', [
            'user' => $connectedUser,
            'allUsers' => $userRepo->findAll()
        ]);
    }
}

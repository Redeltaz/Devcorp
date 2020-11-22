<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Poste;
use App\Entity\PosteLangage;
use App\Form\PosteType;
use App\Repository\PosteRepository;

class ForumController extends AbstractController
{
    /**
     * @Route("/forum", name="forum_home")
     */
    public function index(PosteRepository $repo): Response
    {

        $postes = $repo->findAll();

        return $this->render('forum/index.html.twig', [
            'postes' => $postes,
        ]);
    }

    /**
     * @Route("/forum/create", name="forum_create", methods={"GET", "POST"})
     */
    public function create(Request $request, Poste $poste = null): Response
    {
        if($poste == null)
        {
            $poste = new Poste;
        }

        $manager = $this->getDoctrine()->getManager();

        $form = $this->createForm(PosteType::class, $poste);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $date = new \DateTime();
            $poste->setDate($date);
            $manager->persist($poste);
            $manager->flush();

            return $this->redirectToRoute('forum_home');
        }

        return $this->render('forum/create.html.twig', [
            'form' => $form->createView()
        ]);
    } 

    /**
     * @Route("forum/show/{id<[0-9]+>}", name="forum_show", methods={"GET", "POST"})
     */
    public function show()
    {
        return $this->render('forum/index.html.twig', [
            'controller_name' => 'ForumController',
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilForumController extends AbstractController
{
    /**
     * @Route("/accueil_forum", name="accueil_forum")
     */
    public function index()
    {

        return $this->render('forum/accueilForum.html.twig', [
            'controller_name' => 'AccueilForumController',
        ]);
    }
}

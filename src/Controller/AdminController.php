<?php

namespace App\Controller;

use App\Form\LangageType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\PosteLangage;
use App\Repository\PosteLangageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/langage", name="admin_langage")
     */
    public function index(PosteLangageRepository $repo): Response
    {
        $langages = $repo->findAll();
        
        return $this->render('admin/langages.html.twig', [
            'langages' => $langages,
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/admin/langage/create", name="admin_langage_create")
     * @Route("/admin/langage/modif/{id}", name="admin_langage_modif")
     */
    public function create(Request $request, PosteLangage $poste_langage = null): Response
    {
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
            'user' => $this->getUser()
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Poste;
use App\Entity\Answer;
use App\Entity\PosteLangage;
use App\Form\AnswerType;
use App\Form\PosteType;
use App\Repository\PosteLangageRepository;
use App\Repository\PosteRepository;
use App\Repository\AnswerRepository;

class ForumController extends AbstractController
{
    /**
     * @Route("/forum", name="forum_home")
     */
    public function index(Request $request, PosteRepository $repo, PosteLangageRepository $repoLang): Response
    {
        $allLangages = $repoLang->findAll();

        $langage = $request->query->get('langage');

        $postes = $repo->findAll();

        if($langage === null)
        {
            return $this->render('forum/index.html.twig', [
                'postes' => $postes,
                'langages' => $allLangages,
                'user' => $this->getUser()
            ]);
        }

        $specificPoste = [];

        foreach($postes as $posteRender)
        {
            foreach($posteRender->getLangages() as $langagePoste){
                if($langagePoste->getLangage() === $langage){
                    array_push($specificPoste, $posteRender);
                }
            }
        }

        return $this->render('forum/index.html.twig', [
            'postes' => $specificPoste,
            'langages' => $allLangages,
            'user' => $this->getUser()
        ]);


    }

    /**
     * @Route("/forum/create", name="forum_create", methods={"GET", "POST"})
     * @Route("/forum/update/{id}", name="forum_update")
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
            foreach ($form->get('langages')->getData() as $langage) {
                $poste->addLangage($langage);
                $langage->addPoste($poste);
                $manager->persist($langage);
            }
            $poste->setDate(new \DateTime());
            $poste->setUser($this->getUser());
            $manager->persist($poste);
            $manager->flush();

            return $this->redirectToRoute('forum_show', [
                'id' => $poste->getId(),
                'user' => $this->getUser()
            ]);
        }

        return $this->render('forum/create.html.twig', [
            'form' => $form->createView(),
            'user' => $this->getUser()
        ]);
    } 

    /**
     * @Route("forum/show/{id<[0-9]+>}", name="forum_show", methods={"GET", "POST"})
     */
    public function show(PosteRepository $posteRepo, int $id, Request $request, Answer $answer = null)
    {
        $poste = $posteRepo->find($id);
        $answers = $poste->getAnswers();

        if(! $poste){
            throw $this->createNotFoundException('Le poste #'.$id. ' n\'existe pas !');
        }

        if($answer == null)
        {
            $answer = new Answer;
        }

        $manager = $this->getDoctrine()->getManager();

        $form = $this->createForm(AnswerType::class, $answer);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $answer->setDate(new \DateTime());
            $answer->setUser($this->getUser());
            $answer->setPoste($poste);
            $manager->persist($answer);
            $manager->flush();

            return $this->redirectToRoute('forum_show', [
                'id' => $poste->getId(),
                'answers' => $answers,
                'user' => $this->getUser(),
                'answerForm' => $form->createView()
            ]);
        }


        return $this->render('forum/show.html.twig', [
            'poste' => $poste,
            'answers' => $answers,
            'user' => $this->getUser(),
            'answerForm' => $form->createView()
        ]);
    }
}


<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Poste;
use App\Entity\Answer;
use App\Entity\PosteDislike;
use App\Entity\PosteLangage;
use App\Entity\PosteLike;
use App\Form\AnswerType;
use App\Form\PosteType;
use App\Repository\PosteLangageRepository;
use App\Repository\PosteRepository;
use App\Repository\AnswerRepository;
use App\Repository\PosteDislikeRepository;
use App\Repository\PosteLikeRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class ForumController extends AbstractController
{
    /**
     * @Route("/forum", name="forum_home")
     */
    public function index(Request $request, PosteRepository $repo, PosteLangageRepository $repoLang): Response
    {
        $allLangages = $repoLang->findAll();

        $langage = $request->query->get('langage');

        $postes = $repo->findBy([], ['date' => 'DESC']);

        if($langage){
            $specificPoste = [];

            foreach ($postes as $posteRender) {
                foreach ($posteRender->getLangages() as $langagePoste) {
                    if ($langagePoste->getLangage() === $langage) {
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

        return $this->render('forum/index.html.twig', [
            'postes' => $postes,
            'langages' => $allLangages,
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/forum/allPostes", name="forum_all_postes")
     */
    public function allPostes(PosteRepository $repo, Request $request)
    {
        $search = $request->query->get('search');

        if($search){
            $postes = $repo->findByLetter($search);
        }else{
            $postes = $repo->findBy([], ['date' => 'DESC']);
        }

        $jsonPostes = array();

            foreach($postes as $poste)
            {
                foreach($poste->getLangages() as $langage)
                {
                    $jsonLangages[] = $langage->getLangage();
                }
                $jsonPostes[] = array(
                    'id' => $poste->getId(),
                    'title' => $poste->getTitle(),
                    'content' => $poste->getContent(),
                    'date' => $poste->getDate(),
                    'user' => $poste->getUser()->getPseudo(),
                    'langages' => $jsonLangages
                );
                $jsonLangages = [];
            }

        return new JsonResponse($jsonPostes);
    }

    /**
     * @Route("/forum/create", name="forum_create", methods={"GET", "POST"})
     */
    public function create(Request $request, Poste $poste = null): Response
    {
        if ($poste == null) {
            $poste = new Poste;
        }

        $manager = $this->getDoctrine()->getManager();

        $form = $this->createForm(PosteType::class, $poste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
     * @Route("/forum/update/{id}", name="forum_update")
     */
    public function update(Request $request, Poste $poste = null): Response
    {
        if ($poste == null) {
            $poste = new Poste;
        }

        $manager = $this->getDoctrine()->getManager();

        $form = $this->createForm(PosteType::class, $poste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
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

        if (!$poste) {
            throw $this->createNotFoundException('Le poste #' . $id . ' n\'existe pas !');
        }

        if ($answer == null) {
            $answer = new Answer;
        }

        $manager = $this->getDoctrine()->getManager();

        $form = $this->createForm(AnswerType::class, $answer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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

    /**
     *@Route("forum/show/{id}/like", name="forum_poste_like")
     */
    public function posteLike(Poste $poste, PosteLikeRepository $likeRepo, PosteDislikeRepository $dislikeRepo)
    {
        $user = $this->getUser();
        $manager = $this->getDoctrine()->getManager();

        if (!$user) {
            return $this->json([
                'code' => 403,
                'message' => "Vous devez être connecté"
            ], 403);
        }

        if ($poste->isLiked($user)) {
            $like = $likeRepo->findOneBy([
                'poste' =>  $poste,
                'user' => $user
            ]);

            $manager->remove($like);
            $manager->flush();

            return $this->json([
                'code' => 200,
                'message' => 'Like supprimé',
                'likes' => $likeRepo->count(['poste' => $poste]),
                'dislikes' => $dislikeRepo->count(['poste' => $poste])
            ], 200);
        }

        if ($poste->isDisliked($user)) {
            $dislike = $dislikeRepo->findOneBy([
                'poste' =>  $poste,
                'user' => $user
            ]);

            $manager->remove($dislike);
            $manager->flush();
        }

        $like = new PosteLike();
        $like->setPoste($poste)
            ->setUser($user);

        $manager->persist($like);
        $manager->flush();

        return $this->json([
            'code' => 200,
            'message' => 'Ajout like',
            'likes' => $likeRepo->count(['poste' => $poste]),
            'dislikes' => $dislikeRepo->count(['poste' => $poste])
        ], 200);
    }

    /**
     *@Route("forum/show/{id}/dislike", name="forum_poste_dislike")
     */
    public function posteDislike(Poste $poste, PosteDislikeRepository $dislikeRepo, PosteLikeRepository $likeRepo)
    {
        $user = $this->getUser();
        $manager = $this->getDoctrine()->getManager();

        if (!$user) {
            return $this->json([
                'code' => 403,
                'message' => "Vous devez être connecté"
            ], 403);
        }

        if ($poste->isDisliked($user)) {
            $dislike = $dislikeRepo->findOneBy([
                'poste' =>  $poste,
                'user' => $user
            ]);

            $manager->remove($dislike);
            $manager->flush();

            return $this->json([
                'code' => 200,
                'message' => 'Dislike supprimé',
                'dislikes' => $dislikeRepo->count(['poste' => $poste]),
                'likes' => $likeRepo->count(['poste' => $poste])
            ], 200);
        }

        if ($poste->isLiked($user)) {
            $like = $likeRepo->findOneBy([
                'poste' =>  $poste,
                'user' => $user
            ]);

            $manager->remove($like);
            $manager->flush();
        }

        $dislike = new PosteDislike();
        $dislike->setPoste($poste)
            ->setUser($user);

        $manager->persist($dislike);
        $manager->flush();

        return $this->json([
            'code' => 200,
            'message' => 'Ajout dislike',
            'dislikes' => $dislikeRepo->count(['poste' => $poste]),
            'likes' => $likeRepo->count(['poste' => $poste])
        ], 200);
    }
}
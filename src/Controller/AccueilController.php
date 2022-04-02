<?php

namespace App\Controller;

use App\Entity\Question;
use App\Repository\QuestionRepository;
use App\Repository\ReponseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use function Symfony\Component\DependencyInjection\Loader\Configurator\ref;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(QuestionRepository $questionRepository): Response
    {
        $questions = $questionRepository->findBy(
                [], 
                ["createdAt"=> "DESC"]
            );
        return $this->render('accueil/index.html.twig', [
            "questions"=> $questions
        ]);
    }

    /**
     * Afficher le détails d'une question
     *
     * @param Question|null $question instance de l'entité Question
     * @return Response
     * 
     * @Route("/{slug<[a-z\-0-9]+>}/{id<[0-9]+>}", name="show_question")
     */
    public function show(?Question $question): Response{
        if($question == null){
            throw $this->createNotFoundException("La question demandée n'existe pas !");
        }
        $reponses = $question->getReponses();
        return $this->render("accueil/details.html.twig", [
            "question"=> $question,
            "states"=> Question::$states,
            "reponses"=> $reponses
        ]);
    }
}

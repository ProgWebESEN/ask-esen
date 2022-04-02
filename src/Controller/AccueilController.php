<?php

namespace App\Controller;

use App\Entity\Question;
use App\Repository\QuestionRepository;
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
        $questions = $questionRepository->findAll();
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
     * @Route("/{slug}/{id}", name="show_question")
     */
    public function show(?Question $question): Response{
        if($question == null){
            throw $this->createNotFoundException("La question demandée n'existe pas !");
        }
        return $this->render("accueil/details.html.twig");
    }
}

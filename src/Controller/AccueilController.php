<?php

namespace App\Controller;

use App\Entity\Question;
use App\Form\FormQuestionType;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    /**
     * Permet de publier une question dans le formum
     *
     * @param Request $request requête http
     * @return void
     * 
     * @Route("/create", name="create_question")
     * @IsGranted("ROLE_USER")
     */
    public function create(Request $request, EntityManagerInterface $manager, QuestionRepository $repo){
        /*
        // Code permettant la suppression d'une question
        $question = $repo->find(16);
        $manager->remove($question);
        $manager->flush();
        die();*/
        $question = new Question();
        $formQuestion = $this->createForm(FormQuestionType::class, $question);
        $formQuestion->handleRequest($request);
        if($formQuestion->isSubmitted() and $formQuestion->isValid()){
            $question->setEtat(1);
            $question->setCreatedAt(new \DateTime());
            $manager->persist($question);
            $manager->flush();
            $this->addFlash("_message", "Votre question a bien été publiée");
            return $this->redirectToRoute("create_question");
        }
        return $this->render("questions/create.html.twig", 
            ["formQuestion"=>$formQuestion->createView(), "labelSubmit"=>"Publier votre question"]
        );
    }
}

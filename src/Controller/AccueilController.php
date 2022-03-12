<?php

namespace App\Controller;

use App\Entity\Question;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(EntityManagerInterface $manager): Response
    {
        $questionRepository = $manager->getRepository(Question::class);
        $questions = $questionRepository->findAll();
        return $this->render('accueil/index.html.twig', [
            "questions"=> $questions
        ]);
    }
}

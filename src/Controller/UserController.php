<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    
    /**
     * Inscription des utilisateurs
     *
     * @param Request $request requête http
     * @param EntityManagerInterface $manager gestionnaire des entités
     * @param UserPasswordHasherInterface $encoder encodeue des mots de passe
     * @return Response
     * @Route("/inscription", name="register")
     */
    public function register(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $encoder): Response{
        $user = new User();
        $registrationForm = $this->createForm(RegisterFormType::class, $user);
        $registrationForm->handleRequest($request);
        if($registrationForm->isSubmitted() and $registrationForm->isValid()){
            $password = $encoder->hashPassword($user, $user->getPassword());
            $user->setPassword($password);
            $manager->persist($user);
            $manager->flush();
        }
        return $this->render("user/register.html.twig", [
            "registrationForm"=> $registrationForm->createView()
        ]);
    }

    /**
     * Undocumented function
     *
     * @return void
     * @Route("/login", name="login")
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils){
        $error = $authenticationUtils->getLastAuthenticationError();
        $username = $authenticationUtils->getLastUsername();
        return $this->render("user/login.html.twig", [
            "error"=> $error,
            "username"=> $username
        ]);
    }

    /**
     * Undocumented function
     *
     * @return void
     * @Route("/logout", name="logout")
     */
    public function logout(){}

}

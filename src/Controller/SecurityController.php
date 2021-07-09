<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function registration(EntityManagerInterface $manager,Request $request, UserPasswordEncoderInterface $encoder)
    {

        //USerPasswordInterface pour pouvoir fonctionner attends l'objet User,que celui ci hérite de la class UserInterface, qui attend des méthodes bien spécifiques a implementer afin du bon fonctionnement de l'autentification

        $user=new User();

        $form=$this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()):

            $hash=$user->getPassword();
            $hashPassword=$encoder->encodePassword($user, $hash);

            $user->setPassword($hashPassword);
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', 'Félicitation votre a bien été créé,Connectez vous a présent');
            return $this->redirectToRoute('home');

            endif;



        return $this->render('security/registration.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route ("/login", name="login")
     */
    public function login()
    {


        return $this->render('security/login.html.twig');
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {

        return $this->redirectToRoute('home');

    }











}//fin

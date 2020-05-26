<?php

namespace App\Controller;

use App\Entity\User;
use Cassandra\Type\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/", name="user")
     */
    public function index()
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('user/index.html.twig', [
            'user'=> $user
        ]);
    }

    /**
     * @Route("/add", name="add_user")
     */
    public function addUser(Request $request)
    {
        $form = $this->createForm(UserType::class, new User());

        $form->handleRequest($request);

        if($form->isSubmitted() and $form->isValid()){
            $user = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('user');
        } else {

            return $this->render('user/add.html.twig',
                [
                    'form' => $form->createView()
                ]);
        }
    }


    /**
       @Route("/delete/{user}", name="delete_user")
     *
    public function deleteAction(User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('user');
    } */


}

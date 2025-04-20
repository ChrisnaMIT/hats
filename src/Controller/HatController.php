<?php

namespace App\Controller;

use App\Entity\Hat;
use App\Form\HatType;
use App\Repository\HatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Comment;
use App\Form\CommentType;



final class HatController extends AbstractController
{
    #[Route('/hat', name: 'app_hats')]   // voir tous les Chapeaux , donc le menu
    public function index(HatRepository $hatRepository): Response
    {

        return $this->render('hat/index.html.twig', [
            'hats' => $hatRepository->findAll(),
        ]);
    }

    #[Route('/hat/{id}', name: 'hat_show')]  //Voir un chapeau précis quand on clique pour voir l'article
    public function show(Hat $hat, Request $request, EntityManagerInterface $manager): Response
    {

        $comment = new Comment();
        $comment ->setCreatedAt(new \DateTimeImmutable());
        $comment->setHat($hat);

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('hat_show', ['id' => $hat->getId()]);
        }

        return $this->render('hat/show.html.twig', [
            'hat' => $hat,
            'comment_form' => $form->createView(),
        ]);
    }






    #[Route('hat/{id}/delete', name: 'hat_delete')] // supprimer un chapeau
    public function delete(Hat $hat, EntityManagerInterface $manager): Response
    {
        if($hat)
        {
            $manager->remove($hat);
            $manager->flush();
        }
        return $this->redirectToRoute('app_hats');
    }


    #[Route('/hat/{id}/edit', name: 'hat_edit')]
    public function edit(Hat $hat, Request $request, EntityManagerInterface $manager): Response
    {
        if(!$hat){
            return $this->redirectToRoute('app_hats');
        }
        $form = $this->createForm(HatType::class, $hat);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($hat);
            $manager->flush();
            return $this->redirectToRoute('app_hats');
        }
        return $this->render('hat/edit.html.twig', [
            'hat' => $form->createView(),
        ]);
    }






}

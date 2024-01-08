<?php

namespace App\Controller;

use App\Entity\Actor;
use App\Form\ActorType;
use App\Repository\ActorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/actor', name:'actor_')]
class ActorController extends AbstractController
{
    #[Route('/', name:'index')]
    public function index(ActorRepository $actorRepository): Response
    {
        $actors = $actorRepository->findAll();
        return $this->render('actor/index.html.twig', ['actors' => $actors]);
    }

    #[Route('/new', name:'new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $actor = new Actor();

        $form = $this->createForm(ActorType::class, $actor);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($actor);
            $entityManager->flush();

            return $this->redirectToRoute('actor_index');
        }

        return $this->render('actor/new.html.twig', ['form' => $form]);
    }

    #[Route('/{id}',methods: ['GET'], name:'show')]
    public function show(Actor $actor): Response
    {
        if (!$actor) {
            throw $this->createNotFoundException(
                'No actor : '.$actor.' found in actor\'s table.'
            );
        }

        return $this->render('actor/show.html.twig', ['actor' => $actor]);
    }
}
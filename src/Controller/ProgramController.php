<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;
use App\Form\ProgramType;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\ProgramDuration;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;

#[Route('/program', name:'program_')]
class ProgramController extends AbstractController
{
    #[Route('/', name:'index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();
        return $this->render('program/index.html.twig', ['programs' => $programs]);
    }

    //Add a new program
    #[Route('/new', name:'new')]
    public function newProgram(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger)
    {
        //Create a new Program object
        $program = new Program();
        
        //Create the form, linked with $program
        $form = $this->createForm(ProgramType::class, $program);

        //Get data from HTTP request
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($program->getTitle());
            $program->setSlug($slug);
            $entityManager->persist($program);
            $entityManager->flush();

            //Once the form is submitted, valid and the data is inserted in database, you can edit the success message
            $this->addFlash('success', 'Le nouveau programme a bien été crée');

            //Redirect to programs list
            return $this->redirectToRoute('program_index');
        }

        //Render the form
        return $this->render('program/new.html.twig', ['form' => $form]);

    }

    #[Route('/show/{slug}',methods: ['GET'], name:'show')]
    public function show(
        #[MapEntity(mapping: ['slug' => 'slug'])] Program $program, ProgramDuration $programDuration): Response
    {
        if (!$program) {
            throw $this->createNotFoundException(
                'No program : '.$program.' found in program\'s table.'
            );
        }

        return $this->render('program/show.html.twig', ['program' => $program, 'programDuration' => $programDuration->calculate($program)]);
    }

    #[Route('/show/{slug}/seasons/{season_number}', methods: ['GET'], name:'season_show')]
    public function showSeason(
        #[MapEntity(mapping: ['slug' => 'slug'])] Program $program, 
        #[MapEntity(mapping: ['season_number' => 'number'])] Season $season): Response 
    {
        if (!$program) {
            throw $this->createNotFoundException(
                'No program : '.$program.' found in program\'s table.'
            );
        }
        if (!$season) {
            throw $this->createNotFoundException(
                'No season : '.$season.' found in season\'s table.'
            );
        }

        return $this->render('program/season_show.html.twig', ['program' => $program, 'season' => $season]);
    }

    #[Route('/show/{slug}/seasons/{season_number}/episodes/{episode_title}', methods: ['GET'], name:'episode_show')]
    public function showEpisode(
        #[MapEntity(mapping: ['slug' => 'slug'])] Program $program, 
        #[MapEntity(mapping: ['season_number' => 'number'])] Season $season, 
        #[MapEntity(mapping: ['episode_title' => 'title'])] Episode $episode): Response 
    {
        if (!$program) {
            throw $this->createNotFoundException(
                'No program : '.$program.' found in program\'s table.'
            );
        }
        if (!$season) {
            throw $this->createNotFoundException(
                'No season : '.$season.' found in season\'s table.'
            );
        }

        if (!$episode) {
            throw $this->createNotFoundException(
                'No episode : '.$episode.' found in episode\'s table.'
            );
        }

        return $this->render('program/episode_show.html.twig', ['program' => $program, 'season' => $season, 'episode' => $episode]);
    }
}
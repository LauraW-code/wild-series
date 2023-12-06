<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;

#[Route('/program', name:'program_')]
class ProgramController extends AbstractController
{
    #[Route('/', name:'index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();
        return $this->render('program/index.html.twig', ['programs' => $programs]);
    }

    #[Route('/{id}',methods: ['GET'], name:'show')]
    public function show(Program $program): Response
    {
        if (!$program) {
            throw $this->createNotFoundException(
                'No program : '.$program.' found in program\'s table.'
            );
        }

        return $this->render('program/show.html.twig', ['program' => $program]);
    }

    #[Route('/{program}/seasons/{season}', methods: ['GET'], name:'season_show')]
    public function showSeason(Program $program, Season $season): Response 
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

    #[Route('/{program}/seasons/{season}/episodes/{episode}', methods: ['GET'], name:'episode_show')]
    public function showEpisode(Program $program, Season $season, Episode $episode): Response 
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
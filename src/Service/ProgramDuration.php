<?php

namespace App\Service;

use App\Entity\Program;
use App\Entity\Episode;

class ProgramDuration
{
    public function calculate(Program $program): string 
    {
        $duration = 0;

        foreach($program->getSeasons() as $season) {
            foreach($season->getEpisodes() as $episode) {
                $duration += $episode->getDuration();
            }
        }

        $days = floor ($duration / 1440);
        $hours = floor (($duration - $days * 1440) / 60);
        $minutes = $duration - ($days * 1440) - ($hours * 60);

        return $days . ' days ' . $hours . ' hours ' . $minutes . ' minutes';
    }
}
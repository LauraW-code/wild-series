<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    const SEASON = [
        ['program' => 'program_GameOfThrones', 'number' => '1', 'year' => '2011', 'description' => 'A Westeros, un continent chimérique, de puissantes familles se disputent le trône de fer, symbole de pouvoir absolu sur le royaume des Sept Couronnes.'],
        ['program' => 'program_GameOfThrones', 'number' => '2', 'year' => '2012', 'description' => 'Les Sept Couronnes sont en guerre, et chaque camp cherche à nouer de nouvelles alliances. Grâce au soutien de la puissante Maison Lannister, Joffrey Baratheon, héritier de Robert, détient désormais le trône de fer.'],
        ['program' => 'program_GameOfThrones', 'number' => '3', 'year' => '2013', 'description' => 'La lutte pour le trône de fer continue. Joffrey Baratheon a remporté une précieuse victoire et se retrouve désormais à la tête de la plus grande armée du royaume.'],
        ['program' => 'program_WalkingDead', 'number' => '1', 'year' => '2010', 'description' => 'Après avoir été blessé dans l\'exercice de ses fonctions, le shérif Rick Grimes se réveille d\'un coma de plusieurs semaines et découvre un monde post-apocalyptique où la quasi-totalité de la population américaine s\'est transformée en zombies.'],
        ['program' => 'program_WalkingDead', 'number' => '2', 'year' => '2011', 'description' => 'A la suite de l\'explosion du CDC, Rick et son groupe fuient Atlanta alors que la ville est infestée de zombies. Confrontés à une nouvelle menace, ces derniers trouvent refuge dans la ferme d\'Hershel Greene, un homme dont la famille cache un terrible secret.'],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach(self::SEASON as $seasonData) {
            $season = new Season();
            $season->setProgram($this->getReference($seasonData['program']));
            $season->setNumber($seasonData['number']);
            $season->setYear(($seasonData['year']));
            $season->setDescription(($seasonData['description']));
            $manager->persist($season);
            $replaced = str_replace('program_', '', $seasonData['program']);
            $this->addReference('season_' . $replaced . $season->getNumber(), $season);
            }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [ProgramFixtures::class,];
    }
}

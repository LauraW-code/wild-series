<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    const EPISODE = [
        ['season' => 'season_GameOfThrones1', 'title' => 'L\'hiver vient', 'number' => '1', 'synopsis' => 'Au delà d\'un gigantesque mur de protection de glace dans le nord de Westeros. Robert Baratheon, le roi, arrive avec son cortège au sud du mur de Winterfell pour demander de l\'aide à son vieil ami Eddard Stark.'],
        ['season' => 'season_GameOfThrones1', 'title' => 'La route royale', 'number' => '2', 'synopsis' => 'Le roi Robert Baratheon et son entourage prennent la direction du Sud avec Eddard Stark et ses filles Sansa et Arya. Sur la route, Arya a des ennuis avec le prince Joffrey, ce qui laisse à Eddard une décision difficile à prendre.'],
        ['season' => 'season_GameOfThrones1', 'title' => 'Lord Snow', 'number' => '3', 'synopsis' => 'Eddard Stark arrive à Port-Réal et ce qu\'il découvre le laisse en état de choc. A Castle Black, Jon Snow débute sa formation pour devenir un homme de la Garde de Nuit.'],
        ['season' => 'season_GameOfThrones2', 'title' => 'Le nord se souvient', 'number' => '1', 'synopsis' => 'L\'exécution d\'Eddard Stark a plongé Westeros dans la guerre. Dans le Nord, pendant que Jon Snow et la Garde de Nuit poursuivent leur expédition au-delà du Mur, les Stark, menés par Robb, qui veut venger la mort de son père, poursuivent leur offensive contre les Lannister'],
        ['season' => 'season_GameOfThrones2', 'title' => 'Les contrées nocturnes', 'number' => '2', 'synopsis' => 'Pour contrer le clan Lannister, Stannis Baratheon pousse Davos à trouver de nouveaux alliés. Sur la route du Nord, Arya Stark, qui fuit Port-Réal depuis l\'exécution de son père, se confie à Gendry.'],
        ['season' => 'season_GameOfThrones2', 'title' => 'Ce qui est mort ne saurait mourir', 'number' => '3', 'synopsis' => 'Pour contrer le clan Lannister, Stannis Baratheon pousse Davos à trouver de nouveaux alliés. Sur la route du Nord, Arya Stark, qui fuit Port-Réal depuis l\'exécution de son père, se confie à Gendry.'],
        ['season' => 'season_WalkingDead1', 'title' => 'Passé décomposé', 'number' => '1', 'synopsis' => 'Dans le Kentucky, Rick Grimes, un policier, se réveille à l\'hôpital après plusieurs semaines de coma provoqué par une fusillade qui a mal tourné. Il découvre que le monde, ravagé par une épidémie, est envahi par les morts-vivants.'],
        ['season' => 'season_WalkingDead1', 'title' => 'Tripes', 'number' => '2', 'synopsis' => 'Rick parvient à s\'extraire du char et rencontre un groupe de survivants avec le jeune Glenn, Andrea, Morales, T-Dog et Merle Dixon, un homme passablement raciste et énervé. Tous sont réfugiés dans un immeuble et se demandent comment en sortir.'],
        ['season' => 'season_WalkingDead2', 'title' => 'Ce qui nous attend', 'number' => '1', 'synopsis' => 'Les survivants se retrouvent bloqués sur une route envahie par des carcasses de voitures. Ils décident d\'en profiter pour siphonner les réservoirs. C\'est alors qu\'ils sont surpris par un groupe de zombies.'],
        ['season' => 'season_WalkingDead2', 'title' => 'Saignée', 'number' => '2', 'synopsis' => 'Otis, le chasseur, a indiqué à Rick que les habitants de la ferme pourraient sauver Carl, blessé par balles. Le policier, qui porte son fils inconscient, tente désespérément de rejoindre la ferme.'],
    ];

    public function load(ObjectManager $manager): void
    {

        foreach(self::EPISODE as $episodeData) {
            $episode = new Episode();
            $episode->setSeason($this->getReference($episodeData['season']));
            $episode->setNumber($episodeData['number']);
            $episode->setTitle(($episodeData['title']));
            $episode->setSynopsis(($episodeData['synopsis']));
            $manager->persist($episode);
            }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [SeasonFixtures::class,];
        return [ProgramFixtures::class,];
    }
}

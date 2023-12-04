<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    const PROGRAM = [
        ['title' => 'Game Of Thrones', 'synopsis' => 'Récit épique de la conquête du monde de Westeros', 'category' => 'category_Aventure', 'country' => 'Etats-Unis', 'year' => '2011'],
        ['title' => 'Walking Dead', 'synopsis' => 'Des zombies envahissent la Terre', 'category' => 'category_Horreur', 'country' => 'Etats-Unis', 'year' => '2010'],
        ['title' => 'The Big Bang Theory', 'synopsis' => 'Série comique suivant le quotidien de scientifiques', 'category' => 'category_Comédie', 'country' => 'Etats-Unis', 'year' => '2007'],
        ['title' => 'The 100', 'synopsis' => 'La survie de l\'humanité dépend de 100 adolescents envoyés reconquerir la Terre', 'category' => 'category_Fantastique', 'country' => 'Etats-Unis', 'year' => '2014'],
        ['title' => 'Dr. Stone', 'synopsis' => 'L\'humanité se retrouve figée dans la pierre, son destin est entre les mains d\'un adolescent', 'category' => 'category_Animation', 'country' => 'Japon', 'year' => '2019'],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach(self::PROGRAM as $programData) {
        $program = new Program();
        $program->setTitle($programData['title']);
        $program->setSynopsis($programData['synopsis']);
        $program->setCategory($this->getReference($programData['category']));
        $program->setCountry($programData['country']);
        $program->setYear($programData['year']);
        $manager->persist($program);
        $replaced = str_replace(' ', '', $program->getTitle());
        $this->addReference('program_' . $replaced, $program);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [CategoryFixtures::class,];
    }
}

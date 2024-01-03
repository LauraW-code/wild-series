<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\String\Slugger\SluggerInterface;


class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    const PROGRAM = [
        ['title' => 'Game Of Thrones', 'synopsis' => 'Récit épique de la conquête du monde de Westeros', 'category' => 'category_Aventure', 'country' => 'Etats-Unis', 'year' => '2011', 'poster' => 'build/images/game_of_thrones.jpg'],
        ['title' => 'Walking Dead', 'synopsis' => 'Des zombies envahissent la Terre', 'category' => 'category_Horreur', 'country' => 'Etats-Unis', 'year' => '2010', 'poster' => 'build/images/walking_dead.jpg'],
        ['title' => 'The Big Bang Theory', 'synopsis' => 'Série comique suivant le quotidien de scientifiques', 'category' => 'category_Comédie', 'country' => 'Etats-Unis', 'year' => '2007', 'poster' => 'build/images/big_bang_theory.jpg'],
        ['title' => 'The 100', 'synopsis' => 'La survie de l\'humanité dépend de 100 adolescents envoyés reconquerir la Terre', 'category' => 'category_Fantastique', 'country' => 'Etats-Unis', 'year' => '2014', 'poster' => 'build/images/the_100.jpg'],
        ['title' => 'Dr. Stone', 'synopsis' => 'L\'humanité se retrouve figée dans la pierre, son destin est entre les mains d\'un adolescent', 'category' => 'category_Animation', 'country' => 'Japon', 'year' => '2019', 'poster' => 'build/images/dr_stone.webp'],
    ];

    public function load(ObjectManager $manager): void
    {
        
        $i = 0;
        foreach(self::PROGRAM as $programData) {
            
                $program = new Program();
                $program->setTitle($programData['title']);
                $program->setSynopsis($programData['synopsis']);
                $program->setCategory($this->getReference($programData['category']));
                $program->setCountry($programData['country']);
                $program->setYear($programData['year']);
                $program->setPoster($programData['poster']);

                $slug = $this->slugger->slug($program->getTitle());
                $program->setSlug($slug);

                $this->addReference('program_' . $i , $program);
                $manager->persist($program);
                
                $i++;
                
            }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [CategoryFixtures::class,];
    }
}

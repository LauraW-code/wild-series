<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for($i = 0; $i <=4; $i++) {
                for($e = 1; $e <= 5; $e++) {
                $season = new Season();
                $season->setProgram($this->getReference('program_' . $i));
                $season->setNumber($e);
                $season->setYear($faker->year());
                $season->setDescription($faker->paragraphs(3, true));

                $this->addReference('season_' . $i . '_' . $season->getNumber(), $season);
                $manager->persist($season);  
                }       
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [ProgramFixtures::class,];
    }
}

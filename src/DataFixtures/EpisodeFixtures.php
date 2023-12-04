<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $i = 0;
        
        while($i <= 4) {
            $e = 1;
            while($e <= 5){
                
                for($x = 1; $x <=10; $x++){   
                    $episode = new Episode();
                    $episode->setSeason($this->getReference('season_' . $i . '_' . $e));               
                    $episode->setNumber($x);
                    $episode->setTitle($faker->text(40));
                    $episode->setSynopsis($faker->paragraph(3));
                    $manager->persist($episode);
                    }
                $e++;
                }
                $i++;
                
        }    
        $manager->flush();
    }

    public function getDependencies()
    {
        return [SeasonFixtures::class,];
        return [ProgramFixtures::class,];
    }
}

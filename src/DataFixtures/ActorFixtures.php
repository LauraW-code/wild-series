<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void 
    {
        $faker = Factory::create();

        $progRabbit = 0;

        $i = 0;
        while($i < 10) {
            $actor = new Actor();
            $actor->setName($faker->firstName($gender = null).' '.$faker->lastName());
            $x = 0; 
            
            while($x < 3){
            $actor->addProgram($this->getReference('program_'.$progRabbit % 5));
            $progRabbit++;
            $x++;
            }

            $manager->persist($actor);
            $i++;
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
           ProgramFixtures::class,
        ];
    }
}
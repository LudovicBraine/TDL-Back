<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Task;

class TaskFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for($i=0; $i < 30; $i++){
            $task = new Task();
            $task->setTitle($faker->words(4,true))
                ->setDescription($faker->realText(1800))
                ->setState(Task::STATES[0]);

                $manager->persist($task);
        }
        $manager->flush();
    }
}

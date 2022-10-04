<?php

namespace App\Factory;

use App\Entity\Task;
use Faker\Factory;

class TaskFactory
{
    public function create(): Task
    {
        $faker = Factory::create('fr_FR');
        $task = new Task();
            $task->setTitle($faker->words(4,true))
                ->setDescription($faker->realText(1800))
                ->setState(Task::STATES[0]);

        return $task;
    }
}
<?php 

namespace App\Tests\Functional\Controller\TaskController;

use App\Factory\TaskFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AllTasksTest extends WebTestCase
{
    public function datasetAllTasksTest(EntityManagerInterface $em, TaskFactory $taskFactory): void
    {
        self::bootKernel();
        $task = $taskFactory->create();
        dd($task);
    }

    public function allTasksTest(){

    }
}
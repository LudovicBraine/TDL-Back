<?php

namespace App\Controller;

use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\Task;

class TaskController extends AbstractController
{
    #[Route('/tasks', methods: 'GET')]
    public function alltasks(TaskRepository $taskRepository): Response
    {        
        return $response = $this->json($taskRepository->findAll(), 200, [], ['groups' => 'api_tasks']);
    }

    #[Route('/tasks', methods: 'POST')]
    public function createTask(Request $request, TaskRepository $taskRepository, SerializerInterface $serializer, EntityManagerInterface $em): Response
    { 
        $resolver = new OptionsResolver();
        $resolver->setRequired(['title', 'description'])
            ->setAllowedTypes('title', 'string')
            ->setAllowedTypes('description', 'string');

        $data = $request->getContent();

        $task = $serializer->deserialize($data, Task::class, 'json');

        $em->persist($task);
        $em->flush();
        dd($task);

        return $response = $this->json($taskRepository->findAll(), 200, [], ['groups' => 'api_tasks']);
    }
}

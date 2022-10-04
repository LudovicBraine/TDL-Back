<?php

namespace App\Controller;

use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Task;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class TaskController extends AbstractController
{
    #[Route('/api/tasks', methods: 'GET')]
    public function alltasks(TaskRepository $taskRepository): Response
    {        
        return $this->json($taskRepository->findAll(), 200, [], ['groups' => 'api_tasks']);
    }

    #[Route('/api/tasks', methods: 'POST')]
    public function createTask(Request $request, EntityManagerInterface $em): Response
    { 
        $resolver = new OptionsResolver();
        $resolver->setRequired(['title', 'description'])
            ->setAllowedTypes('title', 'string')
            ->setAllowedTypes('description', 'string');
        $resolver->resolve($request->request->all());

        $data = $request->request->all();
    
        $task = new Task();
        $task->setTitle($data['title']);
        $task->setDescription($data['description']);
    
        try {
            $em->persist($task);
            $em->flush();
        
            return $this->json($task, 201, [], ['groups' => 'api_tasks']);
        } catch (Exception $e) {
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    #[Route('/api/tasks/{id}', methods: 'PUT')]
    #[ParamConverter("task", class: Task::class, options: ['id' => 'id'])]
    public function editTask(Task $task, Request $request, EntityManagerInterface $em): Response
    { 
        $resolver = new OptionsResolver();
        $resolver->setRequired(['title', 'description', 'state'])
            ->setAllowedTypes('title', 'string')
            ->setAllowedTypes('description', 'string')
            ->setAllowedTypes('state', 'string')
            ->setAllowedValues('state', ['TASK_OPEN', 'TASK_FINISHED', 'TASK_LATE']);

        $resolver->resolve($request->request->all());

        $data = $request->request->all();

        $task->setTitle($data['title']);
        $task->setDescription($data['description']);
        $task->setState($data['state']);
        $task->setUpdatedAt(new \DateTimeImmutable());

        try {
            $em->persist($task);
            $em->flush();
            return $this->json($task, 201, [], ['groups' => 'api_tasks']);

        } catch (Exception $e){
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }

    }

    #[Route('/api/tasks/{id}', methods: 'DELETE')]
    #[ParamConverter("task", class: Task::class, options: ['id' => 'id'])]
    public function removeTask(Task $task, Request $request, EntityManagerInterface $em): Response
    { 
        try {
            $em->remove($task);
            $em->flush();
            return new Response('', 200);
        } catch (Exception $e){
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }

    }
}

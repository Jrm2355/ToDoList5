<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TaskController extends AbstractController
{
    #[Route('/tasks', name: 'task_list')]
    public function listAction(TaskRepository $taskRepository)
    {
        $tasks = $taskRepository->findAll();

        return $this->render('task/list.html.twig', [
            'tasks' => $tasks,
        ]);
    }

    #[Route('/tasks/create', name: 'task_create')]
    public function createAction(Request $request, TaskRepository $taskRepository)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task->setCreatedAt(new \DateTimeImmutable);
            $task->setIsDone(false);
            $task->setUser($this->getUser());
            $taskRepository->add($task, true);
            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->renderForm('task/create.html.twig', [
            'task' => $task,
            'form' => $form,
        ]);
    }

    #[Route('/tasks/{id}/toggle', name: 'task_toggle')]
    public function toggleTaskAction(Task $task, TaskRepository $taskRepository)
    {
        $task->toggle(!$task->isIsDone());
        $taskRepository->add($task, true);

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));            

        return $this->redirectToRoute('task_list');
    }

    #[Route('/tasks/{id}/edit', name: 'task_edit')]
    public function editAction(Task $task, Request $request, TaskRepository $taskRepository)
    {
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);
        var_dump($task);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->$taskRepository->add($task, true);

            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    #[Route('/tasks/{id}/delete', name: 'task_delete')]
    public function deleteTaskAction(Task $task, TaskRepository $taskRepository)
    {
        if($task->getUser() === null && $this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN') ){
            $taskRepository->remove($task, true);
            $this->addFlash('success', 'La tâche a bien été supprimée.');
        }elseif($task->getUser() == $this->getUser() && $task->getUser() !== null){
            $taskRepository->remove($task, true);
            $this->addFlash('success', 'La tâche a bien été supprimée.');
        }else{
            $this->addFlash('error', 'Vous n\'avez pas les droits.');
        }
        
        return $this->redirectToRoute('task_list');
    }
}

<?php

namespace App\Controller;

use App\Entity\Todo;
use App\Form\TodoType;
use App\Repository\TodoRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class TodosController extends AbstractController
{

    /**
     * controller repo
     *
     * @var TodoRepository
     */
    private $todoRepository;

    public function __construct(TodoRepository $todoRepository)
    {
        //
        $this->todoRepository = $todoRepository;
    }

    /**
     * @Route("/", name="app_todos",methods={"GET"})
     */
    public function index(Request $request)
    {
        return $this->render('todos/index.html.twig', [
            'dataTable' => [
                'name' => 'Zadaci',
                'action' => 'app_todos',
                'tHeads' => [
                    'id' => '#',
                    'description' => 'Opis posla',
                    'contact' => 'Kontakt',
                    'readableMedium' => 'Medijum',
                    'duration' => 'Trajanje (min)',
                    // 'priority' => 'Prioritet',
                    'worker' => 'Zaposleni'
                ],
                'tRows' => $this->todoRepository->findAll()
            ]
        ]);
    }

    /**
     * @Route("/todos/save/{id?}",name="app_todos_save",methods={"GET"})
     */
    public function show($id = null)
    {
        //
        // creates a todo object and initializes some data for this example
        $todo = $id ? $this->todoRepository->find($id) : new Todo();

        $form = $this->createForm(TodoType::class, $todo, [
            'action' => $this->generateUrl('app_todos_store', ['id' => $id]),
            'method' => 'POST',
        ]);
        //
        return $this->render('/todos/save.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/todos/save/{id?}", name="app_todos_store", methods={"POST","PUT"})
     */
    public function save($id = null, Request $request)
    {
        // just setup a fresh $todo object (remove the example data)
        $todo = $id ? $this->todoRepository->find($id) : new Todo();

        $form = $this->createForm(TodoType::class, $todo);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $todo = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();

            if (!$id) {
                $entityManager->persist($todo);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_todos');
        }
        //
        return $this->render('/todos/save.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/todos/{id}", name="app_todos_destroy", methods={"DELETE"})
     */
    public function destroy($id, Request $request)
    {
        $todo = $this->todoRepository->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($todo);
        $entityManager->flush();

        return $this->redirectToRoute('app_todos');
    }
}

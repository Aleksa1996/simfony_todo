<?php

namespace App\Controller;

use App\Entity\Todo;
use App\Entity\Worker;
use App\Form\WorkerType;
use App\Repository\WorkerRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class WorkersController extends AbstractController
{

    /**
     * controller repo
     *
     * @var WorkerRepository
     */
    private $workerRepository;

    public function __construct(WorkerRepository $workerRepository)
    {
        $this->workerRepository = $workerRepository;
    }

    /**
     * @Route("/workers", name="app_workers",methods={"GET"})
     */
    public function index(Request $request)
    {
        return $this->render('workers/index.html.twig', [
            'dataTable' => [
                'name' => 'Zaposleni',
                'action' => 'app_workers',
                'tHeads' => ['id' => '#', 'firstname' => 'Ime', 'lastname' => 'Prezime', 'positions' => 'Pozicije'],
                'tRows' => $this->workerRepository->findAll()
            ]
        ]);
    }

    /**
     * @Route("/workers/save/{id?}",name="app_workers_save",methods={"GET"})
     */
    public function show($id = null)
    {
        //
        // creates a task object and initializes some data for this example
        $worker = $id ? $this->workerRepository->find($id) : new Worker();

        $form = $this->createForm(WorkerType::class, $worker, [
            'action' => $this->generateUrl('app_workers_store', ['id' => $id]),
            'method' => 'POST',
        ]);
        //
        return $this->render('/workers/save.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/workers/save/{id?}", name="app_workers_store", methods={"POST","PUT"})
     */
    public function save($id = null, Request $request)
    {
        // just setup a fresh $task object (remove the example data)
        $worker = $id ? $this->workerRepository->find($id) : new Worker();

        $form = $this->createForm(WorkerType::class, $worker);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $worker = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();

            if (!$id) {
                $entityManager->persist($worker);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_workers');
        }
        //
        return $this->render('/workers/save.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/workers/{id}", name="app_workers_destroy", methods={"DELETE"})
     */
    public function destroy($id, Request $request)
    {
        $worker = $this->workerRepository->find($id);

        $todos = $worker->getTodos();
        if (count($todos)) {
            $todoNames = $todos->map(function (Todo $todo) {
                return (string) $todo;
            })->toArray();
            //
            $this->addFlash('error', 'Zaposleni ne moze biti obrisan jer ima vezan zadatke: ' . (implode(', ', $todoNames)));
        } else {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($worker);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_workers');
    }
}

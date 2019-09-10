<?php

namespace App\Controller;

use App\Entity\Position;
use App\Entity\Worker;

use App\Form\PositionType;
use App\Repository\PositionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PositionsController extends AbstractController
{
    /**
     * controller repo
     *
     * @var PositionRepository
     */
    private $positionRepository;

    public function __construct(PositionRepository $positionRepository)
    {
        $this->positionRepository = $positionRepository;
    }
    /**
     * @Route("/positions", name="app_positions", methods={"GET"})
     */
    public function index()
    {
        return $this->render('positions/index.html.twig', [
            'dataTable' => [
                'name' => 'Pozicije',
                'action' => 'app_positions',
                'tHeads' => ['id' => '#', 'name' => 'Ime'],
                'tRows' => $this->positionRepository->findAll()
            ]
        ]);
    }


    /**
     * @Route("/positions/save/{id?}", name="app_positions_save",methods={"GET"})
     */
    public function show($id = null)
    {
        //
        // creates a task object and initializes some data for this example
        $position = $id ? $this->positionRepository->find($id) : new Position();

        $form = $this->createForm(PositionType::class, $position, [
            'action' => $this->generateUrl('app_positions_store', ['id' => $id]),
            'method' => 'POST'
        ]);

        return $this->render('/positions/save.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/positions/save/{id?}", name="app_positions_store", methods={"POST","PUT"})
     */
    public function save($id = null, Request $request)
    {
        // just setup a fresh $task object (remove the example data)
        $position = $id ? $this->positionRepository->find($id) : new Position();

        $form = $this->createForm(PositionType::class, $position);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $position = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();

            if (!$id) {
                $entityManager->persist($position);
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_positions');
        }

        return $this->render('/positions/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/positions/{id}", name="app_positions_destroy", methods={"DELETE"})
     */
    public function destroy($id, Request $request)
    {
        $position = $this->positionRepository->find($id);

        $workers = $position->getWorkers();
        if (count($workers)) {
            $workerNames = $workers->map(function (Worker $worker) {
                return $worker->getFirstname() . ' ' . $worker->getLastname();
            })->toArray();
            //
            $this->addFlash('error', 'Pozicija se ne moze izbrisati, zaposleni koji su vezani za ovu poziciju: ' . (implode(', ', $workerNames)));
        } else {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($position);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_positions');
    }
}

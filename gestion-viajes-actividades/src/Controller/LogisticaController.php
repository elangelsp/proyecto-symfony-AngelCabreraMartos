<?php

namespace App\Controller;

use App\Entity\Logistica;
use App\Form\LogisticaType;
use App\Repository\LogisticaRepository;
use App\Repository\ProyectoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/logistica')]
final class LogisticaController extends AbstractController
{
    #[Route(name: 'app_logistica_index', methods: ['GET'])]
    public function index(LogisticaRepository $logisticaRepository, ProyectoRepository $proyectoRepository): Response
    {

        $user = $this->getUser();

        $proyectos = $proyectoRepository->findBy(['user' => $user]);

        $viajeros = [];
        foreach ($proyectos as $proyecto) {
            foreach ($proyecto->getViajeros() as $v) {
                $viajeros[] = $v;
            }
        }

        $logisticas = [];
        foreach ($viajeros as $viajero) {
            foreach ($viajero->getLogisticas() as $logistica) {
                $logisticas[] = $logistica;
            }
        }

        return $this->render('logistica/index.html.twig', [
            'logisticas' => $logisticas,
        ]);
    }

    #[Route('/new', name: 'app_logistica_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $logistica = new Logistica();
        $form = $this->createForm(LogisticaType::class, $logistica);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($logistica);
            $entityManager->flush();

            return $this->redirectToRoute('app_logistica_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('logistica/new.html.twig', [
            'logistica' => $logistica,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_logistica_show', methods: ['GET'])]
    public function show(Logistica $logistica): Response
    {
        return $this->render('logistica/show.html.twig', [
            'logistica' => $logistica,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_logistica_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Logistica $logistica, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LogisticaType::class, $logistica);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_logistica_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('logistica/edit.html.twig', [
            'logistica' => $logistica,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_logistica_delete', methods: ['POST'])]
    public function delete(Request $request, Logistica $logistica, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$logistica->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($logistica);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_logistica_index', [], Response::HTTP_SEE_OTHER);
    }
}

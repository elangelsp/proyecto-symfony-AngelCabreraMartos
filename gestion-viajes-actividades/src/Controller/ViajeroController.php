<?php

namespace App\Controller;

use App\Entity\Viajero;
use App\Form\ViajeroType;
use App\Repository\ViajeroRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/viajero')]
final class ViajeroController extends AbstractController
{
    #[Route(name: 'app_viajero_index', methods: ['GET'])]
    public function index(ViajeroRepository $viajeroRepository): Response
    {
        return $this->render('viajero/index.html.twig', [
            'viajeros' => $viajeroRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_viajero_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $viajero = new Viajero();
        $form = $this->createForm(ViajeroType::class, $viajero);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($viajero);
            $entityManager->flush();

            return $this->redirectToRoute('app_viajero_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('viajero/new.html.twig', [
            'viajero' => $viajero,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_viajero_show', methods: ['GET'])]
    public function show(Viajero $viajero): Response
    {
        return $this->render('viajero/show.html.twig', [
            'viajero' => $viajero,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_viajero_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Viajero $viajero, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ViajeroType::class, $viajero);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_viajero_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('viajero/edit.html.twig', [
            'viajero' => $viajero,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_viajero_delete', methods: ['POST'])]
    public function delete(Request $request, Viajero $viajero, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$viajero->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($viajero);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_viajero_index', [], Response::HTTP_SEE_OTHER);
    }
}

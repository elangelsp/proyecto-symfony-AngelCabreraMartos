<?php

namespace App\Controller;

use App\Entity\Proyecto;
use App\Entity\Viajero;
use App\Form\ViajeroType;
use App\Repository\ViajeroRepository;
use App\Repository\ProyectoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/viajero')]
final class ViajeroController extends AbstractController
{
    #[Route(name: 'app_viajero_index', methods: ['GET'])]
    public function index(ViajeroRepository $viajeroRepository, ProyectoRepository $proyectoRepository): Response
    {

        // Usuario logueado
        $user = $this->getUser();

        // Traer solo proyectos que pertenecen a este usuario
        $proyectos = $proyectoRepository->findBy(['user' => $user]);

        // Recoger todos los viajeros de esos proyectos
        $viajeros = [];
        foreach ($proyectos as $proyecto) {
            foreach ($proyecto->getViajeros() as $v) {
                $viajeros[] = $v;
            }
        }


        return $this->render('viajero/index.html.twig', [
            'viajeros' => $viajeros,
        ]);
    }

    #[Route('/new', name: 'app_viajero_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ProyectoRepository $proyectoRepository): Response
    {

        $proyectos = $proyectoRepository->findBy(['user' => $this->getUser()]);

        $viajero = new Viajero();
        $form = $this->createForm(ViajeroType::class, $viajero);

        $form->add('proyecto_id', EntityType::class, [
        'class' => Proyecto::class,
        'choices' => $proyectos,
        'choice_label' => 'nombre',
        'label' => 'Proyecto',
    ]);

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

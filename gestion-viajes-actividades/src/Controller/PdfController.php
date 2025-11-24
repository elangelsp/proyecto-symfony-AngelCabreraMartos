<?php

namespace App\Controller;

use App\Entity\Proyecto;
use Nucleos\DompdfBundle\Factory\DompdfFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Vich\UploaderBundle\Storage\StorageInterface;

final class PdfController extends AbstractController
{
    #[Route('/{id}/pdf/{viajeroId}', name: 'app_proyecto_pdf', methods: ['GET'])]
    public function generarPdf(Proyecto $proyecto, DompdfFactoryInterface $factory, int $viajeroId, StorageInterface $storage): Response
    {
        $viajero = null;
        foreach ($proyecto->getViajeros() as $v) {
            if ($v->getId() === $viajeroId) {
                $viajero = $v;
                break;
            }
        }

        // Obtener rutas ABSOLUTAS del sistema de archivos
        $proyectoImagenPath = null;
        if ($proyecto->getImagen()) {
            // resolvePath devuelve la ruta completa del archivo
            $proyectoImagenPath = $storage->resolvePath($proyecto, 'imageFile');
        }

        $viajeroImagenPath = null;
        if ($viajero->getImagen()) {
            $viajeroImagenPath = $storage->resolvePath($viajero, 'imageFile');
        }

        if (!$viajero) {
            throw $this->createNotFoundException('Viajero no encontrado');
        }

        $html = $this->renderView('pdf/index.html.twig', [
            'proyecto' => $proyecto,
            'viajero' => $viajero,
            'proyectoImagenPath' => $proyectoImagenPath,
            'viajeroImagenPath' => $viajeroImagenPath,
        ]);
        
        $pdf = $factory->create();
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();
        
        return new Response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="proyecto_' . $proyecto->getId() . '.pdf"'
        ]);
    }
}

<?php

namespace App\Entity;

use App\Repository\ActividadesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActividadesRepository::class)]
class Actividades
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'actividades')]
    #[ORM\JoinColumn(nullable: false)]
    private ?viajero $viajero_id = null;

    #[ORM\Column(length: 60)]
    private ?string $nombre = null;

    #[ORM\Column]
    private ?\DateTime $fecha_celebracion = null;

    #[ORM\Column(length: 60)]
    private ?string $lugar = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getViajeroId(): ?Viajero
    {
        return $this->viajero_id;
    }

    public function setViajeroId(?viajero $viajero_id): static
    {
        $this->viajero_id = $viajero_id;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getFechaCelebracion(): ?\DateTime
    {
        return $this->fecha_celebracion;
    }

    public function setFechaCelebracion(\DateTime $fecha_celebracion): static
    {
        $this->fecha_celebracion = $fecha_celebracion;

        return $this;
    }

    public function getLugar(): ?string
    {
        return $this->lugar;
    }

    public function setLugar(string $lugar): static
    {
        $this->lugar = $lugar;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\LogisticaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LogisticaRepository::class)]
class Logistica
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'logisticas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?viajero $viajero_id = null;

    #[ORM\Column(length: 20)]
    private ?string $tipo_viaje = null;

    #[ORM\Column(length: 255)]
    private ?string $destino_lugar = null;

    #[ORM\Column(length: 40)]
    private ?string $medio_transporte = null;

    #[ORM\Column]
    private ?\DateTime $salida = null;

    #[ORM\Column]
    private ?\DateTime $llegada = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getViajeroId(): ?Viajero
    {
        return $this->viajero_id;
    }

    public function setViajeroId(?Viajero $viajero_id): static
    {
        $this->viajero_id = $viajero_id;

        return $this;
    }

    public function getTipoViaje(): ?string
    {
        return $this->tipo_viaje;
    }

    public function setTipoViaje(string $tipo_viaje): static
    {
        $this->tipo_viaje = $tipo_viaje;

        return $this;
    }

    public function getDestinoLugar(): ?string
    {
        return $this->destino_lugar;
    }

    public function setDestinoLugar(string $destino_lugar): static
    {
        $this->destino_lugar = $destino_lugar;

        return $this;
    }

    public function getMedioTransporte(): ?string
    {
        return $this->medio_transporte;
    }

    public function setMedioTransporte(string $medio_transporte): static
    {
        $this->medio_transporte = $medio_transporte;

        return $this;
    }

    public function getSalida(): ?\DateTime
    {
        return $this->salida;
    }

    public function setSalida(\DateTime $salida): static
    {
        $this->salida = $salida;

        return $this;
    }

    public function getLlegada(): ?\DateTime
    {
        return $this->llegada;
    }

    public function setLlegada(\DateTime $llegada): static
    {
        $this->llegada = $llegada;

        return $this;
    }
}

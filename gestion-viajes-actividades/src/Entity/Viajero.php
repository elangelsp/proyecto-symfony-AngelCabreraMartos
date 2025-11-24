<?php

namespace App\Entity;

use App\Repository\ViajeroRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ViajeroRepository::class)]
class Viajero
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'viajeros')]
    #[ORM\JoinColumn(nullable: false)]
    private ?proyecto $proyecto_id = null;

    #[ORM\Column(length: 40)]
    private ?string $nombre_completo = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $referencia = null;

    #[ORM\Column]
    private ?int $telefono = null;

    #[ORM\Column(length: 40)]
    private ?string $ciudad = null;

    #[ORM\Column(length: 40)]
    private ?string $pais = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imagen = null;

    /**
     * @var Collection<int, Logistica>
     */
    #[ORM\OneToMany(targetEntity: Logistica::class, mappedBy: 'viajero_id', orphanRemoval: true)]
    private Collection $logisticas;

    public function __construct()
    {
        $this->logisticas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProyectoId(): ?proyecto
    {
        return $this->proyecto_id;
    }

    public function setProyectoId(?proyecto $proyecto_id): static
    {
        $this->proyecto_id = $proyecto_id;

        return $this;
    }

    public function getNombreCompleto(): ?string
    {
        return $this->nombre_completo;
    }

    public function setNombreCompleto(string $nombre_completo): static
    {
        $this->nombre_completo = $nombre_completo;

        return $this;
    }

    public function getReferencia(): ?string
    {
        return $this->referencia;
    }

    public function setReferencia(?string $referencia): static
    {
        $this->referencia = $referencia;

        return $this;
    }

    public function getTelefono(): ?int
    {
        return $this->telefono;
    }

    public function setTelefono(int $telefono): static
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getCiudad(): ?string
    {
        return $this->ciudad;
    }

    public function setCiudad(string $ciudad): static
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    public function getPais(): ?string
    {
        return $this->pais;
    }

    public function setPais(string $pais): static
    {
        $this->pais = $pais;

        return $this;
    }

    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    public function setImagen(?string $imagen): static
    {
        $this->imagen = $imagen;

        return $this;
    }

    /**
     * @return Collection<int, Logistica>
     */
    public function getLogisticas(): Collection
    {
        return $this->logisticas;
    }

    public function addLogistica(Logistica $logistica): static
    {
        if (!$this->logisticas->contains($logistica)) {
            $this->logisticas->add($logistica);
            $logistica->setViajeroId($this);
        }

        return $this;
    }

    public function removeLogistica(Logistica $logistica): static
    {
        if ($this->logisticas->removeElement($logistica)) {
            // set the owning side to null (unless already changed)
            if ($logistica->getViajeroId() === $this) {
                $logistica->setViajeroId(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\ViajeroRepository;
use App\Entity\Proyecto;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ViajeroRepository::class)]
#[Vich\Uploadable]
class Viajero
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'viajeros')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Proyecto $proyecto_id = null;

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

    #[Vich\UploadableField(mapping: 'imagen', fileNameProperty: 'imagen')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, Logistica>
     */
    #[ORM\OneToMany(targetEntity: Logistica::class, mappedBy: 'viajero_id', orphanRemoval: true)]
    private Collection $logisticas;

    /**
     * @var Collection<int, Actividades>
     */
    #[ORM\OneToMany(targetEntity: Actividades::class, mappedBy: 'viajero_id', orphanRemoval: true)]
    private Collection $actividades;

    public function __construct()
    {
        $this->logisticas = new ArrayCollection();
        $this->actividades = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProyectoId(): ?Proyecto
    {
        return $this->proyecto_id;
    }

    public function setProyectoId(?Proyecto $proyecto_id): static
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

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }
    public function setImageName(): ?string
    {
        return $this->imagen;
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

    /**
     * @return Collection<int, Actividades>
     */
    public function getActividades(): Collection
    {
        return $this->actividades;
    }

    public function addActividade(Actividades $actividade): static
    {
        if (!$this->actividades->contains($actividade)) {
            $this->actividades->add($actividade);
            $actividade->setViajeroId($this);
        }

        return $this;
    }

    public function removeActividade(Actividades $actividade): static
    {
        if ($this->actividades->removeElement($actividade)) {
            // set the owning side to null (unless already changed)
            if ($actividade->getViajeroId() === $this) {
                $actividade->setViajeroId(null);
            }
        }

        return $this;
    }
}

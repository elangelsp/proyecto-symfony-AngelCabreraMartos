<?php

namespace App\Entity;

use App\Repository\ProyectoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ProyectoRepository::class)]
#[Vich\Uploadable]
class Proyecto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 40)]
    private ?string $nombre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $descripcion = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imagen = null;

    #[Vich\UploadableField(mapping: 'imagen', fileNameProperty: 'imagen')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, Viajero>
     */
    #[ORM\OneToMany(targetEntity: Viajero::class, mappedBy: 'proyecto_id', orphanRemoval: true)]
    private Collection $viajeros;

    public function __construct()
    {
        $this->viajeros = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function setImageFile(?File $imageProyect = null): void
    {
        $this->imageFile = $imageProyect;

        if (null !== $imageProyect) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }
    public function getImageFile(): ?File
    {
        return $this->imageFile;
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
     * @return Collection<int, Viajero>
     */
    public function getViajeros(): Collection
    {
        return $this->viajeros;
    }

    public function addViajero(Viajero $viajero): static
    {
        if (!$this->viajeros->contains($viajero)) {
            $this->viajeros->add($viajero);
            $viajero->setProyectoId($this);
        }

        return $this;
    }

    public function removeViajero(Viajero $viajero): static
    {
        if ($this->viajeros->removeElement($viajero)) {
            // set the owning side to null (unless already changed)
            if ($viajero->getProyectoId() === $this) {
                $viajero->setProyectoId(null);
            }
        }

        return $this;
    }
}

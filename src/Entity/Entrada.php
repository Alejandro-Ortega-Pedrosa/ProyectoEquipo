<?php

namespace App\Entity;

use App\Repository\EntradaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EntradaRepository::class)]
class Entrada
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'entradas')]
    private ?Partido $Partido = null;

    #[ORM\Column(length: 50)]
    private ?string $Precio = null;

    #[ORM\Column(length: 100)]
    private ?string $Zona = null;

    #[ORM\Column(length: 100)]
    private ?string $Fecha = null;

    #[ORM\Column(length: 100)]
    private ?string $Hora = null;

    #[ORM\Column(length: 100)]
    private ?string $Nombre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPartido(): ?Partido
    {
        return $this->Partido;
    }

    public function setPartido(?Partido $Partido): self
    {
        $this->Partido = $Partido;

        return $this;
    }

    public function getPrecio(): ?string
    {
        return $this->Precio;
    }

    public function setPrecio(string $Precio): self
    {
        $this->Precio = $Precio;

        return $this;
    }

    public function getZona(): ?string
    {
        return $this->Zona;
    }

    public function setZona(string $Zona): self
    {
        $this->Zona = $Zona;

        return $this;
    }

    public function getFecha(): ?string
    {
        return $this->Fecha;
    }

    public function setFecha(string $Fecha): self
    {
        $this->Fecha = $Fecha;

        return $this;
    }

    public function getHora(): ?string
    {
        return $this->Hora;
    }

    public function setHora(string $Hora): self
    {
        $this->Hora = $Hora;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->Nombre;
    }

    public function setNombre(string $Nombre): self
    {
        $this->Nombre = $Nombre;

        return $this;
    }
}

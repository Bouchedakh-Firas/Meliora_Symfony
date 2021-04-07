<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reclamation
 *
 * @ORM\Table(name="reclamation", indexes={@ORM\Index(name="id_client", columns={"id_client"})})
 * @ORM\Entity(repositoryClass="App\Repository\ReclamationRepository")
 */
class Reclamation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="sujetReclamation", type="string", length=255, nullable=false)
     */
    private $sujetreclamation;

    /**
     * @var string
     *
     * @ORM\Column(name="statu", type="string", length=255, nullable=false)
     */
    private $statu;

    /**
     * @var string
     *
     * @ORM\Column(name="descriptionReclamation", type="string", length=255, nullable=false)
     */
    private $descriptionreclamation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateReclamation", type="date", nullable=false)
     */
    private $datereclamation;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_client", referencedColumnName="id")
     * })
     */
    private $idClient;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSujetreclamation(): ?string
    {
        return $this->sujetreclamation;
    }

    public function setSujetreclamation(string $sujetreclamation): self
    {
        $this->sujetreclamation = $sujetreclamation;

        return $this;
    }

    public function getStatu(): ?string
    {
        return $this->statu;
    }

    public function setStatu(string $statu): self
    {
        $this->statu = $statu;

        return $this;
    }

    public function getDescriptionreclamation(): ?string
    {
        return $this->descriptionreclamation;
    }

    public function setDescriptionreclamation(string $descriptionreclamation): self
    {
        $this->descriptionreclamation = $descriptionreclamation;

        return $this;
    }

    public function getDatereclamation(): ?\DateTimeInterface
    {
        return $this->datereclamation;
    }

    public function setDatereclamation(\DateTimeInterface $datereclamation): self
    {
        $this->datereclamation = $datereclamation;

        return $this;
    }

    public function getIdClient(): ?User
    {
        return $this->idClient;
    }

    public function setIdClient(?User $idClient): self
    {
        $this->idClient = $idClient;

        return $this;
    }


}

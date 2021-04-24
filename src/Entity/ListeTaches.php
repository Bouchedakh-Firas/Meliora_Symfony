<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ListeTaches
 *
 * @ORM\Table(name="liste_taches", indexes={@ORM\Index(name="id_t", columns={"id_t"}), @ORM\Index(name="id_p", columns={"id_p"})})
 * @ORM\Entity(repositoryClass="App\Repository\ListeTachesRepository")
 */
class ListeTaches
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
     * @var \DateTime
     * @Assert\DateTime
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nom_tache", type="string", length=255, nullable=true)
     */
    private $nomTache;

    /**
     * @var string|null
     *
     * @ORM\Column(name="type_tache", type="string", length=255, nullable=true)
     */
    private $typeTache;

    /**
     * @var int
     *
     * @ORM\Column(name="etat_du_tache", type="integer", nullable=false)
     */
    private $etatDuTache = '0';

    /**
     * @var \Planning
     *
     * @ORM\ManyToOne(targetEntity="Planning")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_p", referencedColumnName="id")
     * })
     */
    private $idP;

    /**
     * @var \Tache
     *
     * @ORM\ManyToOne(targetEntity="Tache")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_t", referencedColumnName="id")
     * })
     */
    private $idT;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getNomTache(): ?string
    {
        return $this->nomTache;
    }

    public function setNomTache(?string $nomTache): self
    {
        $this->nomTache = $nomTache;

        return $this;
    }

    public function getTypeTache(): ?string
    {
        return $this->typeTache;
    }

    public function setTypeTache(?string $typeTache): self
    {
        $this->typeTache = $typeTache;

        return $this;
    }

    public function getEtatDuTache(): ?int
    {
        return $this->etatDuTache;
    }

    public function setEtatDuTache(int $etatDuTache): self
    {
        $this->etatDuTache = $etatDuTache;

        return $this;
    }

    public function getIdP(): ?Planning
    {
        return $this->idP;
    }

    public function setIdP(?Planning $idP): self
    {
        $this->idP = $idP;

        return $this;
    }

    public function getIdT(): ?Tache
    {
        return $this->idT;
    }

    public function setIdT(?Tache $idT): self
    {
        $this->idT = $idT;

        return $this;
    }


}

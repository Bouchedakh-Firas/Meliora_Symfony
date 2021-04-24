<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlanningUser
 *
 * @ORM\Table(name="planning_user", indexes={@ORM\Index(name="id_u", columns={"id_u"}), @ORM\Index(name="id_p", columns={"id_p"})})
 * @ORM\Entity(repositoryClass="App\Repository\PlanningUserRepository")
 */
class PlanningUser
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
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_ajout", type="datetime", nullable=true, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $dateAjout = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_suppr", type="date", nullable=true)
     */
    private $dateSuppr;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nom_planning", type="string", length=255, nullable=true)
     */
    private $nomPlanning;

    /**
     * @var int|null
     *
     * @ORM\Column(name="nb_tache", type="integer", nullable=true)
     */
    private $nbTache;

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
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_u", referencedColumnName="id")
     * })
     */
    private $idU;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateAjout(): ?\DateTimeInterface
    {
        return $this->dateAjout;
    }

    public function setDateAjout(?\DateTimeInterface $dateAjout): self
    {
        $this->dateAjout = $dateAjout;

        return $this;
    }

    public function getDateSuppr(): ?\DateTimeInterface
    {
        return $this->dateSuppr;
    }

    public function setDateSuppr(?\DateTimeInterface $dateSuppr): self
    {
        $this->dateSuppr = $dateSuppr;

        return $this;
    }

    public function getNomPlanning(): ?string
    {
        return $this->nomPlanning;
    }

    public function setNomPlanning(?string $nomPlanning): self
    {
        $this->nomPlanning = $nomPlanning;

        return $this;
    }

    public function getNbTache(): ?int
    {
        return $this->nbTache;
    }

    public function setNbTache(?int $nbTache): self
    {
        $this->nbTache = $nbTache;

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

    public function getIdU(): ?User
    {
        return $this->idU;
    }

    public function setIdU(?User $idU): self
    {
        $this->idU = $idU;

        return $this;
    }


}

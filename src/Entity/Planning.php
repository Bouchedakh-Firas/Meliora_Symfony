<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;

use App\Entity\Coach;
use App\Entity\User;

/**
 * Planning
 *
 * @ORM\Table(name="planning", indexes={@ORM\Index(name="id_C", columns={"id_C"}), @ORM\Index(name="id_U", columns={"id_U"})})
 * @ORM\Entity(repositoryClass="App\Repository\PlanningRepository")
 */
class Planning
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
     * @var int|null
     *
     * @ORM\Column(name="liker", type="integer", nullable=true)
     */
    private $liker = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="disliker", type="integer", nullable=true)
     */
    private $disliker = '0';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_creation", type="date", nullable=true)
     */
    private $dateCreation;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nom_p", type="string", length=255, nullable=true)
     */
    private $nomP;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_U", referencedColumnName="id")
     * })
     */
    private $idU;

    /**
     * @var \Coach
     *
     * @ORM\ManyToOne(targetEntity="Coach")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_C", referencedColumnName="id")
     * })
     */
    private $idC;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLiker(): ?int
    {
        return $this->liker;
    }

    public function setLiker(?int $liker): self
    {
        $this->liker = $liker;

        return $this;
    }

    public function getDisliker(): ?int
    {
        return $this->disliker;
    }

    public function setDisliker(?int $disliker): self
    {
        $this->disliker = $disliker;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(?\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getNomP(): ?string
    {
        return $this->nomP;
    }

    public function setNomP(?string $nomP): self
    {
        $this->nomP = $nomP;

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

    public function getIdC(): ?Coach
    {
        return $this->idC;
    }

    public function setIdC(?Coach $idC): self
    {
        $this->idC = $idC;

        return $this;
    }


}

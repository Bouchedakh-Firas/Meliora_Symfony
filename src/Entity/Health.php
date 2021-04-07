<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Health
 *
 * @ORM\Table(name="health", indexes={@ORM\Index(name="fk_health", columns={"id_User"})})
 * @ORM\Entity(repositoryClass="App\Repository\HealthRepository")
 */
class Health
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_health", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idHealth;

    /**
     * @var int
     *
     * @ORM\Column(name="total_calories", type="integer", nullable=false)
     */
    private $totalCalories;

    /**
     * @var int
     *
     * @ORM\Column(name="total_carbs", type="integer", nullable=false)
     */
    private $totalCarbs;

    /**
     * @var int
     *
     * @ORM\Column(name="total_gras", type="integer", nullable=false)
     */
    private $totalGras;

    /**
     * @var int
     *
     * @ORM\Column(name="moy_tension", type="integer", nullable=false)
     */
    private $moyTension;

    /**
     * @var int
     *
     * @ORM\Column(name="poids", type="integer", nullable=false)
     */
    private $poids;

    /**
     * @var int
     *
     * @ORM\Column(name="hauteur", type="integer", nullable=false)
     */
    private $hauteur;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_User", referencedColumnName="id")
     * })
     */
    private $idUser;

    public function getIdHealth(): ?int
    {
        return $this->idHealth;
    }

    public function getTotalCalories(): ?int
    {
        return $this->totalCalories;
    }

    public function setTotalCalories(int $totalCalories): self
    {
        $this->totalCalories = $totalCalories;

        return $this;
    }

    public function getTotalCarbs(): ?int
    {
        return $this->totalCarbs;
    }

    public function setTotalCarbs(int $totalCarbs): self
    {
        $this->totalCarbs = $totalCarbs;

        return $this;
    }

    public function getTotalGras(): ?int
    {
        return $this->totalGras;
    }

    public function setTotalGras(int $totalGras): self
    {
        $this->totalGras = $totalGras;

        return $this;
    }

    public function getMoyTension(): ?int
    {
        return $this->moyTension;
    }

    public function setMoyTension(int $moyTension): self
    {
        $this->moyTension = $moyTension;

        return $this;
    }

    public function getPoids(): ?int
    {
        return $this->poids;
    }

    public function setPoids(int $poids): self
    {
        $this->poids = $poids;

        return $this;
    }

    public function getHauteur(): ?int
    {
        return $this->hauteur;
    }

    public function setHauteur(int $hauteur): self
    {
        $this->hauteur = $hauteur;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }


}

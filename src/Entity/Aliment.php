<?php

namespace App\Entity;
use App\Entity\Regime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Aliment
 *
 * @ORM\Table(name="aliment", indexes={@ORM\Index(name="id_regime", columns={"id_regime"})})
 * @ORM\Entity(repositoryClass="App\Repository\AlimentRepository")
 */
class Aliment
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_aliment", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idAliment;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255, nullable=false)
     */
    private $libelle;

    /**
     * @var string
     *
     * @ORM\Column(name="recette", type="text", length=65535, nullable=false)
     */
    private $recette;

    /**
     * @var float
     *
     * @ORM\Column(name="calorie", type="float", precision=10, scale=0, nullable=false)
     */
    private $calorie;

    /**
     * @var float
     *
     * @ORM\Column(name="gras", type="float", precision=10, scale=0, nullable=false)
     */
    private $gras;

    /**
     * @var float
     *
     * @ORM\Column(name="carbs", type="float", precision=10, scale=0, nullable=false)
     */
    private $carbs;

    /**
     * @var \Regime
     *
     * @ORM\ManyToOne(targetEntity="Regime")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_regime", referencedColumnName="id_regime")
     * })
     */
    private $idRegime;

    public function getIdAliment(): ?int
    {
        return $this->idAliment;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getRecette(): ?string
    {
        return $this->recette;
    }

    public function setRecette(string $recette): self
    {
        $this->recette = $recette;

        return $this;
    }

    public function getCalorie(): ?float
    {
        return $this->calorie;
    }

    public function setCalorie(float $calorie): self
    {
        $this->calorie = $calorie;

        return $this;
    }

    public function getGras(): ?float
    {
        return $this->gras;
    }

    public function setGras(float $gras): self
    {
        $this->gras = $gras;

        return $this;
    }

    public function getCarbs(): ?float
    {
        return $this->carbs;
    }

    public function setCarbs(float $carbs): self
    {
        $this->carbs = $carbs;

        return $this;
    }

    public function getIdRegime(): ?Regime
    {
        return $this->idRegime;
    }

    public function setIdRegime(?Regime $idRegime): self
    {
        $this->idRegime = $idRegime;

        return $this;
    }


}

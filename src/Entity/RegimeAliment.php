<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RegimeAliment
 *
 * @ORM\Table(name="regime_aliment", indexes={@ORM\Index(name="fk_idaliment", columns={"id_aliment"}), @ORM\Index(name="fk_idregime", columns={"id_regime"})})
 * @ORM\Entity(repositoryClass="App\Repository\RegimeAlimentRepository")
 */
class RegimeAliment
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
     * @var int
     *
     * @ORM\Column(name="id_aliment", type="integer", nullable=false)
     */
    private $idAliment;

    /**
     * @var int
     *
     * @ORM\Column(name="id_regime", type="integer", nullable=false)
     */
    private $idRegime;

    /**
     * RegimeAliment constructor.
     * @param int $idAliment
     * @param int $idRegime
     */

    public function __construct(int $idAliment, int $idRegime)
    {
        $this->idAliment = $idAliment;
        $this->idRegime = $idRegime;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdAliment(): ?int
    {
        return $this->idAliment;
    }

    public function setIdAliment(int $idAliment): self
    {
        $this->idAliment = $idAliment;

        return $this;
    }

    public function getIdRegime(): ?int
    {
        return $this->idRegime;
    }

    public function setIdRegime(int $idRegime): self
    {
        $this->idRegime = $idRegime;

        return $this;
    }


}

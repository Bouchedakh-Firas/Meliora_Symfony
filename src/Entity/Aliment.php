<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Aliment
 *
 * @ORM\Table(name="aliment", indexes={@ORM\Index(name="id_regime", columns={"id_regime"})})
 * @ORM\Entity
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
     * @ORM\Column(name="recette", type="string", length=255, nullable=false)
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


}

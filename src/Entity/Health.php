<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Health
 *
 * @ORM\Table(name="health", indexes={@ORM\Index(name="fk_health", columns={"id_User"})})
 * @ORM\Entity
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


}

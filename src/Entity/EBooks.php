<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EBooks
 *
 * @ORM\Table(name="e_books", indexes={@ORM\Index(name="id_c", columns={"id_c"})})
 * @ORM\Entity
 */
class EBooks
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
     * @ORM\Column(name="auteur", type="string", length=255, nullable=false)
     */
    private $auteur;

    /**
     * @var string
     *
     * @ORM\Column(name="genre", type="string", length=255, nullable=false)
     */
    private $genre;

    /**
     * @var int
     *
     * @ORM\Column(name="favoris", type="integer", nullable=false)
     */
    private $favoris;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255, nullable=false)
     */
    private $titre;

    /**
     * @var float
     *
     * @ORM\Column(name="evaluation", type="float", precision=10, scale=0, nullable=false)
     */
    private $evaluation;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=false)
     */
    private $image;

    /**
     * @var \Citations
     *
     * @ORM\ManyToOne(targetEntity="Citations")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_c", referencedColumnName="id")
     * })
     */
    private $idC;


}

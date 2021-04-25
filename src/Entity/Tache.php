<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tache
 *
 * @ORM\Table(name="tache", indexes={@ORM\Index(name="tache_citation", columns={"id_c"}), @ORM\Index(name="tache_ebook", columns={"id_e"})})
 * @ORM\Entity
 */
class Tache
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
     * @ORM\Column(name="type_tache", type="string", length=0, nullable=false)
     */
    private $typeTache;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_tache", type="string", length=255, nullable=false)
     */
    private $nomTache;

    /**
     * @var int|null
     *
     * @ORM\Column(name="id_v", type="integer", nullable=true)
     */
    private $idV;

    /**
     * @var int|null
     *
     * @ORM\Column(name="id_m", type="integer", nullable=true)
     */
    private $idM;

    /**
     * @var int
     *
     * @ORM\Column(name="idnonnull", type="integer", nullable=false)
     */
    private $idnonnull;

    /**
     * @var int|null
     *
     * @ORM\Column(name="like", type="integer", nullable=true)
     */
    private $like = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="dislike", type="integer", nullable=true)
     */
    private $dislike = '0';

    /**
     * @var \Citations
     *
     * @ORM\ManyToOne(targetEntity="Citations")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_c", referencedColumnName="id")
     * })
     */
    private $idC;

    /**
     * @var \EBooks
     *
     * @ORM\ManyToOne(targetEntity="EBooks")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_e", referencedColumnName="id")
     * })
     */
    private $idE;


}

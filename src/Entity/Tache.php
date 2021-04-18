<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Tache
 *
 * @ORM\Table(name="tache", indexes={@ORM\Index(name="tache_ebook", columns={"id_e"}), @ORM\Index(name="tache_citation", columns={"id_c"})})
 * @ORM\Entity(repositoryClass="App\Repository\TacheRepository")
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
     * @ORM\Column(name="idnonnull", type="integer", nullable=true)
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

    
    /**
     * @ORM\ManyToMany(targetEntity=Video::class, inversedBy="taches")
     */
    private $Videos;

    public function __construct()
    {
        $this->Videos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeTache(): ?string
    {
        return $this->typeTache;
    }

    public function setTypeTache(string $typeTache): self
    {
        $this->typeTache = $typeTache;

        return $this;
    }

    public function getNomTache(): ?string
    {
        return $this->nomTache;
    }

    public function setNomTache(string $nomTache): self
    {
        $this->nomTache = $nomTache;

        return $this;
    }

    public function getIdV(): ?int
    {
        return $this->idV;
    }

    public function setIdV(?int $idV): self
    {
        $this->idV = $idV;

        return $this;
    }

    public function getIdM(): ?int
    {
        return $this->idM;
    }

    public function setIdM(?int $idM): self
    {
        $this->idM = $idM;

        return $this;
    }

    public function getIdnonnull(): ?int
    {
        return $this->idnonnull;
    }

    public function setIdnonnull(int $idnonnull): self
    {
        $this->idnonnull = $idnonnull;

        return $this;
    }

    public function getLike(): ?int
    {
        return $this->like;
    }

    public function setLike(?int $like): self
    {
        $this->like = $like;

        return $this;
    }

    public function getDislike(): ?int
    {
        return $this->dislike;
    }

    public function setDislike(?int $dislike): self
    {
        $this->dislike = $dislike;

        return $this;
    }

    public function getIdC(): ?Citations
    {
        return $this->idC;
    }

    public function setIdC(?Citations $idC): self
    {
        $this->idC = $idC;

        return $this;
    }

    public function getIdE(): ?EBooks
    {
        return $this->idE;
    }

    public function setIdE(?EBooks $idE): self
    {
        $this->idE = $idE;

        return $this;
    }

    /**
     * @return Collection|Video[]
     */
    public function getVideos(): Collection
    {
        return $this->Videos;
    }

    public function addVideo(Video $video): self
    {
        if (!$this->Videos->contains($video)) {
            $this->Videos[] = $video;
        }

        return $this;
    }

    public function removeVideo(Video $video): self
    {
        $this->Videos->removeElement($video);

        return $this;
    }


}

<?php

namespace App\Entity;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * EBooks
 *
 * @ORM\Table(name="e_books", indexes={@ORM\Index(name="id_c", columns={"id_c"})})
 * @ORM\Entity(repositoryClass="App\Repository\EBooksRepository")

 */
class EBooks
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("ebooks:read")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="auteur", type="string", length=255, nullable=false)
     * @Groups("ebooks:read")
     */
    private $auteur;

    /**
     * @var string
     *
     * @ORM\Column(name="genre", type="string", length=255, nullable=false)
     * @Groups("ebooks:read")
     */
    private $genre;

    /**
     * @var int
     *
     * @ORM\Column(name="favoris", type="integer", nullable=false)
     * @Groups("ebooks:read")
     */
    private $favoris;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255, nullable=false)
     * @Groups("ebooks:read")
     */
    private $titre;

    /**
     * @var float
     *
     * @ORM\Column(name="evaluation", type="float", precision=10, scale=0, nullable=false)
     * @Groups("ebooks:read")
     */
    private $evaluation;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=false)
     * @Groups("ebooks:read")
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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    public function setAuteur(string $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getFavoris(): ?int
    {
        return $this->favoris;
    }

    public function setFavoris(int $favoris): self
    {
        $this->favoris = $favoris;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getEvaluation(): ?float
    {
        return $this->evaluation;
    }

    public function setEvaluation(float $evaluation): self
    {
        $this->evaluation = $evaluation;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

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


}

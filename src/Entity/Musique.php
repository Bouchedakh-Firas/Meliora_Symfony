<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Musique
 *
 * @ORM\Table(name="musique")
 * @ORM\Entity(repositoryClass="App\Repository\MusiqueRepository")
 */
class Musique
{
    /**
     * @var int
     *
     * @ORM\Column(name="nombre", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=50, nullable=false)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="genre", type="string", length=20, nullable=false)
     */
    private $genre;

    /**
     * @var string
     *
     * @ORM\Column(name="Artiste", type="string", length=50, nullable=false)
     */
    private $artiste;

    /**
     * @var string
     *
     * @ORM\Column(name="MusicPath", type="string", length=250, nullable=false)
     */
    private $musicpath;

    /**
     * @var string|null
     *
     * @ORM\Column(name="image", type="string", length=250, nullable=true, options={"default"="noImage"})
     */
    private $image = 'noImage';

    public function getNombre(): ?int
    {
        return $this->nombre;
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

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getArtiste(): ?string
    {
        return $this->artiste;
    }

    public function setArtiste(string $artiste): self
    {
        $this->artiste = $artiste;

        return $this;
    }

    public function getMusicpath(): ?string
    {
        return $this->musicpath;
    }

    public function setMusicpath(string $musicpath): self
    {
        $this->musicpath = $musicpath;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }


}

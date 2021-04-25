<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\MusiqueRepository;

/**
 * Musique
 *
 * @ORM\Table(name="musique")
 *  @ORM\Entity(repositoryClass="App\Repository\MusiqueRepository")
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
      *  @Groups("Musique:read")
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="genre", type="string", length=20, nullable=false)
     * @Groups("Musique:read")
     */
    private $genre;

    /**
     * @var string
     *
     * @ORM\Column(name="Artiste", type="string", length=50, nullable=false)
     * @Groups("Musique:read")
     */
    private $artiste;

    /**
     * @var string
     *
     * @ORM\Column(name="MusicPath", type="string", length=250, nullable=false)
     * @Groups("Musique:read")
     */
    private $musicpath;

    /**
     * @var string|null
     *
     * @ORM\Column(name="image", type="string", length=250, nullable=true, options={"default"="noImage"})
     * @Groups("Musique:read")
     */
    private $image = 'noImage';

    /**
     * @return int
     */
    public function getNombre(): int
    {
        return $this->nombre;
    }

    /**
     * @param int $nombre
     */
    public function setNombre(int $nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * @return string
     */
    public function getTitre(): ?string
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     */
    public function setTitre(string $titre): void
    {
        $this->titre = $titre;
    }

    /**
     * @return string
     */
    public function getGenre(): ?string
    {
        return $this->genre;
    }

    /**
     * @param string $genre
     */
    public function setGenre(string $genre): void
    {
        $this->genre = $genre;
    }

    /**
     * @return string
     */
    public function getArtiste(): ?string
    {
        return $this->artiste;
    }

    /**
     * @param string $artiste
     */
    public function setArtiste(string $artiste): void
    {
        $this->artiste = $artiste;
    }

    /**
     * @return string
     */
    public function getMusicpath(): ?string
    {
        return $this->musicpath;
    }

    /**
     * @param string $musicpath
     */
    public function setMusicpath(string $musicpath): void
    {
        $this->musicpath = $musicpath;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string|null $image
     */
    public function setImage(?string $image): void
    {
        $this->image = $image;
    }


}

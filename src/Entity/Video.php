<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Video
 *
 * @ORM\Table(name="video")
 * @ORM\Entity
 */
class Video
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_v", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idV;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=20, nullable=false)
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
     * @ORM\Column(name="VideoPath", type="string", length=500, nullable=false)
     */
    private $videopath;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Thumbnail", type="string", length=255, nullable=true)
     */
    private $thumbnail;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_likes", type="integer", nullable=false)
     */
    private $nbLikes;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_dislikes", type="integer", nullable=false)
     */
    private $nbDislikes;

    /**
     * @var int
     *
     * @ORM\Column(name="mailSent", type="integer", nullable=false)
     */
    private $mailsent = '0';


    /**
     * @return int
     */
    public function getIdV(): ?int
    {
        return $this->idV;
    }

    /**
     * @param int $idV
     */
    public function setIdV(int $idV): void
    {
        $this->idV = $idV;
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
    public function setTitre(string $titre):void
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
    public function getVideopath(): ?string
    {
        return $this->videopath;
    }

    /**
     * @param string $videopath
     */
    public function setVideopath(string $videopath): void
    {
        $this->videopath = $videopath;
    }

    /**
     * @return string|null
     */
    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    /**
     * @param string|null $thumbnail
     */
    public function setThumbnail(?string $thumbnail): void
    {
        $this->thumbnail = $thumbnail;
    }

    /**
     * @return int
     */
    public function getNbLikes(): ?int
    {
        return $this->nbLikes;
    }

    /**
     * @param int $nbLikes
     */
    public function setNbLikes(int $nbLikes): void
    {
        $this->nbLikes = $nbLikes;
    }

    /**
     * @return int
     */
    public function getNbDislikes(): ?int
    {
        return $this->nbDislikes;
    }

    /**
     * @param int $nbDislikes
     */
    public function setNbDislikes(int $nbDislikes): void
    {
        $this->nbDislikes = $nbDislikes;
    }

    /**
     * @return int
     */
    public function getMailsent()
    {
        return $this->mailsent;
    }

    /**
     * @param int $mailsent
     */
    public function setMailsent($mailsent): void
    {
        $this->mailsent = $mailsent;
    }

}

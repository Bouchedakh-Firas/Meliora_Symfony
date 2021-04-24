<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Video
 *
 * @ORM\Table(name="video")
 * @ORM\Entity(repositoryClass="App\Repository\VideoRepository")
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
     * @ORM\ManyToMany(targetEntity=Tache::class, mappedBy="Videos")
     */
    private $taches;

    public function __construct()
    {
        $this->taches = new ArrayCollection();
    }

    public function getIdV(): ?int
    {
        return $this->idV;
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

    public function getVideopath(): ?string
    {
        return $this->videopath;
    }

    public function setVideopath(string $videopath): self
    {
        $this->videopath = $videopath;

        return $this;
    }

    public function getNbLikes(): ?int
    {
        return $this->nbLikes;
    }

    public function setNbLikes(int $nbLikes): self
    {
        $this->nbLikes = $nbLikes;

        return $this;
    }

    public function getNbDislikes(): ?int
    {
        return $this->nbDislikes;
    }

    public function setNbDislikes(int $nbDislikes): self
    {
        $this->nbDislikes = $nbDislikes;

        return $this;
    }

    public function getMailsent(): ?int
    {
        return $this->mailsent;
    }

    public function setMailsent(int $mailsent): self
    {
        $this->mailsent = $mailsent;

        return $this;
    }

    /**
     * @return Collection|Tache[]
     */
    public function getTaches(): Collection
    {
        return $this->taches;
    }

    public function addTach(Tache $tach): self
    {
        if (!$this->taches->contains($tach)) {
            $this->taches[] = $tach;
            $tach->addVideo($this);
        }

        return $this;
    }

    public function removeTach(Tache $tach): self
    {
        if ($this->taches->removeElement($tach)) {
            $tach->removeVideo($this);
        }

        return $this;
    }


}

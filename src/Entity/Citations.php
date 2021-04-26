<?php

namespace App\Entity;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * Citations
 *
 * @ORM\Table(name="citations")
 * @ORM\Entity(repositoryClass="App\Repository\CitationsRepository")

 */
class Citations
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * * @Groups("citations:read")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="auteur", type="string", length=255, nullable=false)
     * * @Groups("citations:read")
     */
    private $auteur;
     /**
     * @var int|null
     *
     * @ORM\Column(name="liker", type="integer", nullable=true)
     * * @Groups("citations:read")
     */
    private $liker = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="disliker", type="integer", nullable=true)
     * * @Groups("citations:read")
     */
    private $disliker = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=255, nullable=false)
     * * @Groups("citations:read")
     */
    private $text;

    /**
     * @var string
     *
     * @ORM\Column(name="genre", type="string", length=255, nullable=false)
     * * @Groups("citations:read")
     */
    private $genre;

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

    public function getText(): ?string
    {
        return $this->text;
    }
    public function getLiker(): ?int
    {
        return $this->liker;
    }

    public function setLiker(?int $liker): self
    {
        $this->liker = $liker;

        return $this;
    }
    public function getDisliker(): ?int
    {
        return $this->disliker;
    }

    public function setDisliker(?int $disliker): self
    {
        $this->disliker = $disliker;

        return $this;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

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


}

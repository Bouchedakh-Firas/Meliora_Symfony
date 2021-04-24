<?php

namespace App\Entity;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;

/**
 * Coach
 *
 * @ORM\Table(name="coach")
 * @ORM\Entity(repositoryClass="App\Repository\CoachRepository")
 * @UniqueEntity("email",message = " '{{ value }}'  il y a un compt inscit avec ce mail")
 */
class Coach
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("coachs:read")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=30)
     * @Groups("coachs:read")
     * 
     * @Assert\Length(
     * min = 5,
     * max = 50,
     * minMessage = "Le nom du Coach doit comporter au moins {{ limit }} caractères",
     * maxMessage = "Le nom du Coach doit comporter au plus {{ limit }} caractères"
     * )
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=30)
     * @Groups("coachs:read")
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=50)
     * @Groups("coachs:read")
     *   @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     * @Groups("coachs:read")
     *
     * 
     */
    private $password;

    /**
     * @var int
     *
     * @ORM\Column(name="tel", type="integer")
     * @Assert\Regex("/[0-9]{8}/",message = "vous avez entrer seulement'{{ value }}' chiffre /il faut 8")
     * @Groups("coachs:read")
     */
    private $tel;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255)
     * @Groups("coachs:read")
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     * @Groups("coachs:read")
     * 
     */
    private $image;

    /**
     * @var float
     *
     * @ORM\Column(name="rating", type="float", precision=10, scale=0)
     * @Groups("coachs:read")
     */
    private $rating;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     * @Groups("coachs:read")
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }
   

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getTel(): ?int
    {
        return $this->tel;
    }

    public function setTel(int $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

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

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(float $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}

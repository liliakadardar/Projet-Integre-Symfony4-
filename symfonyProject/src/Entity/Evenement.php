<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass=EvenementRepository::class)
 */
class Evenement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     * @Assert\NotBlank
     */
    private $nom_e;

    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThanOrEqual(value = "today")
     */
    private $date_deb;

    /**
     * @ORM\Column(type="date")
     *  @Assert\GreaterThanOrEqual(value = "today")
     * @Assert\Expression(
     *     "this.getDateFin() >= this.getDateDeb()",
     *     message="Verifier votre date"
     * )
     * )

     */
    private $date_fin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image_e;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank
     */
    private $prix_e;

    /**
     * @ORM\ManyToOne(targetEntity=CategorieE::class, inversedBy="evenements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categoryId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomE(): ?string
    {
        return $this->nom_e;
    }

    public function setNomE(string $nom_e): self
    {
        $this->nom_e = $nom_e;

        return $this;
    }

    public function getDateDeb(): ?\DateTimeInterface
    {
        return $this->date_deb;
    }

    public function setDateDeb(\DateTimeInterface $date_deb): self
    {
        $this->date_deb = $date_deb;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getImageE(): ?string
    {
        return $this->image_e;
    }

    public function setImageE(string $image_e): self
    {
        $this->image_e = $image_e;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrixE(): ?float
    {
        return $this->prix_e;
    }

    public function setPrixE(float $prix_e): self
    {
        $this->prix_e = $prix_e;

        return $this;
    }

    public function getCategoryId(): ?CategorieE
    {
        return $this->categoryId;
    }

    public function setCategoryId(?CategorieE $categoryId): self
    {
        $this->categoryId = $categoryId;

        return $this;
    }
}

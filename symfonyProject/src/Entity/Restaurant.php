<?php

namespace App\Entity;

use App\Repository\RestaurantRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=RestaurantRepository::class)
 */
class Restaurant
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     * @Assert\NotBlank (message="Veuillez remplir ce champs")
     */
    private $nom_resto;

    /**
     * @ORM\Column(type="bigint")
     *  @Assert\NotBlank (message="Veuillez remplir ce champs")
     *  @Assert\Length(min=8 ) 
     *
     */
    private $numTel;

    /**
     * @ORM\Column(type="datetime")
     * * @Assert\NotBlank 
     * @Assert\Range(
     *      min = "now"
     * )
     */
    private $horraire_ouverture;

    /**
     * @ORM\Column(type="datetime")
     *  * @Assert\NotBlank
     * @Assert\Range(
     *      min = "now"
     * )
     *  @Assert\GreaterThanOrEqual(propertyPath="horraire_ouverture", message="La date du fin doit être supérieure à la date début")
     */
    private $horraire_fermeture;

    /**
     * @ORM\ManyToOne(targetEntity=Region::class, inversedBy="restaurants")
     */
    private $idRegion;

    /**
     * @ORM\Column(type="string", length=255)
     
     
     */
    private $image;

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomResto(): ?string
    {
        return $this->nom_resto;
    }

    public function setNomResto(?string $nom_resto): self
    {
        $this->nom_resto = $nom_resto;

        return $this;
    }

    public function getNumTel(): ?string
    {
        return $this->numTel;
    }

    public function setNumTel(?string $numTel): self
    {
        $this->numTel = $numTel;

        return $this;
    }

    public function getHorraireOuverture(): ?\DateTimeInterface
    {
        return $this->horraire_ouverture;
    }

    public function setHorraireOuverture(?\DateTimeInterface $horraire_ouverture): self
    {
        $this->horraire_ouverture = $horraire_ouverture;

        return $this;
    }

    public function getHorraireFermeture(): ?\DateTimeInterface
    {
        return $this->horraire_fermeture;
    }

    public function setHorraireFermeture(?\DateTimeInterface $horraire_fermeture): self
    {
        $this->horraire_fermeture = $horraire_fermeture;

        return $this;
    }

    public function getIdRegion(): ?Region
    {
        return $this->idRegion;
    }

    public function setIdRegion(?Region $idRegion): self
    {
        $this->idRegion = $idRegion;

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

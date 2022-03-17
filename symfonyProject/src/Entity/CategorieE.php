<?php

namespace App\Entity;

use App\Repository\CategorieERepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass=CategorieERepository::class)
 * @UniqueEntity("nomCat_e")
 */
class CategorieE
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $nomCat_e;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image_e;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $desciption;

    /**
     * @ORM\OneToMany(targetEntity=Evenement::class, mappedBy="categorie")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $evenements;

    public function __construct()
    {
        $this->evenements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString() {
        return $this->nomCat_e;
    }

    public function getNomCatE(): ?string
    {
        return $this->nomCat_e;
    }

    public function setNomCatE(string $nomCat_e): self
    {
        $this->nomCat_e = $nomCat_e;

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

    public function getDesciption(): ?string
    {
        return $this->desciption;
    }

    public function setDesciption(string $desciption): self
    {
        $this->desciption = $desciption;

        return $this;
    }

    /**
     * @return Collection|Evenement[]
     */
    public function getEvenements(): Collection
    {
        return $this->evenements;
    }

    public function addEvenement(Evenement $evenement): self
    {
        if (!$this->evenements->contains($evenement)) {
            $this->evenements[] = $evenement;
            $evenement->setCategorie($this);
        }

        return $this;
    }

    public function removeEvenement(Evenement $evenement): self
    {
        if ($this->evenements->removeElement($evenement)) {
            // set the owning side to null (unless already changed)
            if ($evenement->getCategorie() === $this) {
                $evenement->setCategorie(null);
            }
        }

        return $this;
    }
}

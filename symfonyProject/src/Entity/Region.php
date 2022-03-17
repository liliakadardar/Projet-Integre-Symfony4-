<?php

namespace App\Entity;

use App\Repository\RegionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=RegionRepository::class)
 */
class Region
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     * * @Assert\NotBlank (message="Veuillez remplir ce champs")
     */
    private $nomregion;
    /**
     * @ORM\Column(type="string", length=255)

     
     */
    private $image;


    /**
     * @ORM\OneToMany(targetEntity=Restaurant::class, mappedBy="idRegion",orphanRemoval=true)
     */
    private $restaurants;

    public function __construct()
    {
        $this->restaurants = new ArrayCollection();
    }



    public function getNomregion(): ?string
    {
        return $this->nomregion;
    }

    public function setNomregion(?string $nomregion): self
    {
        $this->nomregion = $nomregion;

        return $this;
    }


    /**
     * @return Collection|Restaurant[]
     */
    public function getRestaurants(): Collection
    {
        return $this->restaurants;
    }

    public function addRestaurant(Restaurant $restaurant): self
    {
        if (!$this->restaurants->contains($restaurant)) {
            $this->restaurants[] = $restaurant;
            $restaurant->setIdRegion($this);
        }

        return $this;
    }

    public function removeRestaurant(Restaurant $restaurant): self
    {
        if ($this->restaurants->removeElement($restaurant)) {
            // set the owning side to null (unless already changed)
            if ($restaurant->getIdRegion() === $this) {
                $restaurant->setIdRegion(null);
            }
        }

        return $this;
    }
    public function getId(): ?int
    {
        return $this->id;
    }


    public function __toString()
    {
        return $this->getNomregion();
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


}

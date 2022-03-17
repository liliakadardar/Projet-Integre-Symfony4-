<?php

namespace App\Entity;

use App\Repository\CategorieMRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieMRepository::class)
 */
class CategorieM
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomCatM;

    /**
     * @ORM\OneToMany(targetEntity=Materiel::class, mappedBy="categorie")
     */
    private $materiels;

    public function __construct()
    {
        $this->materiels = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function setIdCatM(int $idCatM): self
    {
        $this->idCatM = $idCatM;

        return $this;
    }

    public function getNomCatM(): ?string
    {
        return $this->nomCatM;
    }

    public function setNomCatM(string $nomCatM): self
    {
        $this->nomCatM = $nomCatM;

        return $this;
    }


    /**
     * @return Collection|Materiel[]
     */
    public function getMateriels(): Collection
    {
        return $this->materiels;
    }

    public function addMateriel(Materiel $materiel): self
    {
        if (!$this->materiels->contains($materiel)) {
            $this->materiels[] = $materiel;
            $materiel->setCategorie($this);
        }

        return $this;
    }

    public function removeMateriel(Materiel $materiel): self
    {
        if ($this->materiels->removeElement($materiel)) {
            // set the owning side to null (unless already changed)
            if ($materiel->getCategorie() === $this) {
                $materiel->setCategorie(null);
            }
        }

        return $this;
    }
}

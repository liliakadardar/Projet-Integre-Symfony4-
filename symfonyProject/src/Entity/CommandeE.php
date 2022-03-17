<?php

namespace App\Entity;

use App\Repository\CommandeERepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CommandeERepository::class)
 */
class CommandeE
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_creation;



    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank (message="a remplir")
     */
    private $address_destination;

    /**
     * @ORM\OneToMany(targetEntity=Commande::class, mappedBy="commandeE_c")
     */
    private $commandes;

    /**
     * @ORM\ManyToOne(targetEntity=Evenement::class, inversedBy="commandeEs")
     */
    private $evenement;

    public function __construct()
    {
        $this->id_e = new ArrayCollection();
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTimeInterface $date_creation): self
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    /**
     * @return Collection|Evenement[]
     */
    public function getIdE(): Collection
    {
        return $this->id_e;
    }

    public function addIdE(Evenement $idE): self
    {
        if (!$this->id_e->contains($idE)) {
            $this->id_e[] = $idE;
            $idE->setEC($this);
        }

        return $this;
    }

    public function removeIdE(Evenement $idE): self
    {
        if ($this->id_e->removeElement($idE)) {
            // set the owning side to null (unless already changed)
            if ($idE->getEC() === $this) {
                $idE->setEC(null);
            }
        }

        return $this;
    }

    public function getAddressDestination(): ?string
    {
        return $this->address_destination;
    }

    public function setAddressDestination(string $address_destination): self
    {
        $this->address_destination = $address_destination;

        return $this;
    }

    /**
     * @return Collection|Commande[]
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setCommandeEC($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getCommandeEC() === $this) {
                $commande->setCommandeEC(null);
            }
        }

        return $this;
    }

    public function getEvenement(): ?Evenement
    {
        return $this->evenement;
    }

    public function setEvenement(?Evenement $evenement): self
    {
        $this->evenement = $evenement;

        return $this;
    }
}

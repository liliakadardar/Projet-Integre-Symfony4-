<?php

namespace App\Entity;

use App\Repository\CommandeTRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CommandeTRepository::class)
 */
class CommandeT
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
     * @ORM\OneToMany(targetEntity=Commande::class, mappedBy="commmandeT_c")
     */
    private $commandesT;

    /**
     * @ORM\OneToMany(targetEntity=Transport::class, mappedBy="commandeT")
     */
    private $transport;

    public function __construct()
    {
        $this->id_t = new ArrayCollection();
        $this->commandesT = new ArrayCollection();
        $this->transport = new ArrayCollection();
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
     * @return Collection|Transport[]
     */
    public function getIdT(): Collection
    {
        return $this->id_t;
    }

    public function addIdT(Transport $idT): self
    {
        if (!$this->id_t->contains($idT)) {
            $this->id_t[] = $idT;
            $idT->setTC($this);
        }

        return $this;
    }

    public function removeIdT(Transport $idT): self
    {
        if ($this->id_t->removeElement($idT)) {
            // set the owning side to null (unless already changed)
            if ($idT->getTC() === $this) {
                $idT->setTC(null);
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
    public function getCommandesT(): Collection
    {
        return $this->commandesT;
    }

    public function addCommandesT(Commande $commandesT): self
    {
        if (!$this->commandesT->contains($commandesT)) {
            $this->commandesT[] = $commandesT;
            $commandesT->setCommmandeTC($this);
        }

        return $this;
    }

    public function removeCommandesT(Commande $commandesT): self
    {
        if ($this->commandesT->removeElement($commandesT)) {
            // set the owning side to null (unless already changed)
            if ($commandesT->getCommmandeTC() === $this) {
                $commandesT->setCommmandeTC(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Transport>
     */
    public function getTransport(): Collection
    {
        return $this->transport;
    }

    public function addTransport(Transport $transport): self
    {
        if (!$this->transport->contains($transport)) {
            $this->transport[] = $transport;
            $transport->setCommandeT($this);
        }

        return $this;
    }

    public function removeTransport(Transport $transport): self
    {
        if ($this->transport->removeElement($transport)) {
            // set the owning side to null (unless already changed)
            if ($transport->getCommandeT() === $this) {
                $transport->setCommandeT(null);
            }
        }

        return $this;
    }
}

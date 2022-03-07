<?php

namespace App\Entity;

use App\Repository\CategorieTRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CategorieTRepository::class)
 */
class CategorieT
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     * @Assert\NotBlank(message="type transport is required")
     */
    private $type_transport;

    /**
     * @ORM\Column(type="string", length=255)
     *
     */
    private $image_transport;

    /**
     * @ORM\OneToMany(targetEntity=Transport::class, mappedBy="categorieT",orphanRemoval=true)
     */
    private $transport;

    public function __construct()
    {
        $this->transport = new ArrayCollection();
    }






    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeTransport(): ?string
    {
        return $this->type_transport;
    }

    public function setTypeTransport(string $type_transport): self
    {
        $this->type_transport = $type_transport;

        return $this;
    }

    public function getImageTransport(): ?string
    {
        return $this->image_transport;
    }

    public function setImageTransport(string $image_transport): self
    {
        $this->image_transport = $image_transport;

        return $this;
    }






    public function __toString()
    {
        return $this->getTypeTransport();
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
            $transport->setCategorieT($this);
        }

        return $this;
    }

    public function removeTransport(Transport $transport): self
    {
        if ($this->transport->removeElement($transport)) {
            // set the owning side to null (unless already changed)
            if ($transport->getCategorieT() === $this) {
                $transport->setCategorieT(null);
            }
        }

        return $this;
    }
}

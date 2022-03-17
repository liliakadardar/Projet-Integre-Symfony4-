<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 */
class Commande
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
    private $date_commande;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse_destination;


    /**
     * @ORM\ManyToOne(targetEntity=CommandeE::class, inversedBy="commandes")
     */
    private $commandeE_c;

    /**
     * @ORM\ManyToOne(targetEntity=CommandeM::class, inversedBy="commandesM")
     */
    private $CommandeM_c;

    /**
     * @ORM\ManyToOne(targetEntity=CommandeT::class, inversedBy="commandesT")
     */
    private $commmandeT_c;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="commande")
     */
    private $utilisateur;

 //  /**
 //   * @ORM\Column(type="float", nullable=true)
 //   */
 //  private $Total_c;



    public function __construct()
    {
        $this->idArticle = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->date_commande;
    }

    public function setDateCommande(\DateTimeInterface $date_commande): self
    {
        $this->date_commande = $date_commande;

        return $this;
    }

    public function getAdresseDestination(): ?string
    {
        return $this->adresse_destination;
    }

    public function setAdresseDestination(string $adresse_destination): self
    {
        $this->adresse_destination = $adresse_destination;

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getIdArticle(): Collection
    {
        return $this->idArticle;
    }

    public function addIdArticle(Article $idArticle): self
    {
        if (!$this->idArticle->contains($idArticle)) {
            $this->idArticle[] = $idArticle;
        }

        return $this;
    }

    public function removeIdArticle(Article $idArticle): self
    {
        $this->idArticle->removeElement($idArticle);

        return $this;
    }
    /**
     * toString
     * @return string
     */
    public function __toString()
    {
        return $this->get();
    }

    public function getCommandeEC(): ?CommandeE
    {
        return $this->commandeE_c;
    }

    public function setCommandeEC(?CommandeE $commandeE_c): self
    {
        $this->commandeE_c = $commandeE_c;

        return $this;
    }

    public function getCommmandeMC(): ?self
    {
        return $this->commmandeM_c;
    }

    public function setCommmandeMC(?self $commmandeM_c): self
    {
        $this->commmandeM_c = $commmandeM_c;

        return $this;
    }

    public function getCommandeMC(): ?CommandeM
    {
        return $this->CommandeM_c;
    }

    public function setCommandeMC(?CommandeM $CommandeM_c): self
    {
        $this->CommandeM_c = $CommandeM_c;

        return $this;
    }

    public function getCommmandeTC(): ?CommandeT
    {
        return $this->commmandeT_c;
    }

    public function setCommmandeTC(?CommandeT $commmandeT_c): self
    {
        $this->commmandeT_c = $commmandeT_c;

        return $this;
    }

  // public function getTotalC(): ?float
  // {
  //     return $this ->Total_c;
  //     //$total = 0;
  //     //        $totalE = 0;
  //     //        $totalM = 0;
  //     //        $totalT = 0;
  //     //
  //     //        foreach($this->getCommandeEC() as $itemE)
  //     //        {
  //     //            $totalItem = $itemE['produit']->getPrixE();
  //     //            $totalE += $totalItem ;
  //     //        }
  //     //        foreach($this->getCommandeMC() as $itemM)
  //     //        {
  //     //            $totalItem = $itemM['produit']->getPrixM() * $itemM['quantite']->getQuantite();
  //     //            $totalM += $totalItem ;
  //     //        }
  //     //        foreach($this->getCommmandeTC() as $itemT)
  //     //        {
  //     //            $totalItem = $itemT['produit']->getPrixT();
  //     //            $totalT += $totalItem ;
  //     //        }
  //     //        $total = $totalE +$totalM +$totalT ;
  //     //        return $total;
  // }

  // public function setTotalC(?float $Total_c): self
  // {
  //     $this->Total_c = $Total_c;

  //     return $this;
  // }

  public function getUtilisateur(): ?Utilisateur
  {
      return $this->utilisateur;
  }

  public function setUtilisateur(?Utilisateur $utilisateur): self
  {
      $this->utilisateur = $utilisateur;

      return $this;
  }
}

<?php

namespace App\Entity;

use App\Repository\MaterielRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=MaterielRepository::class)
 */
class Materiel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $nom;

    /**
     * @ORM\Column(type="string")
     */
    private $prenom;

    /**
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * @ORM\Column(type="integer")
     */
    private $numtel;


    /**
     * @ORM\Column(type="float")
     * @Assert\Positive(
     * message="le prix ne doit pas etre negatif ou égale à 0")
     */
    private $prix_m;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Cette valeur ne doit pas être vide")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $nom_materiel;

    /**
     * @ORM\ManyToOne(targetEntity=CategorieM::class, inversedBy="materiels")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity=CommandeM::class, inversedBy="materiel")
     */
    private $commandeM;






    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom): void
    {
        $this->prenom = $prenom;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getNumtel()
    {
        return $this->numtel;
    }

    /**
     * @param mixed $numtel
     */
    public function setNumtel($numtel): void
    {
        $this->numtel = $numtel;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrixM(): ?float
    {
        return $this->prix_m;
    }

    public function setPrixM(float $prix_m): self
    {
        $this->prix_m = $prix_m;

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

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getNomMateriel(): ?string
    {
        return $this->nom_materiel;
    }

    public function setNomMateriel(string $nom_materiel): self
    {
        $this->nom_materiel = $nom_materiel;

        return $this;
    }


    public function getIdcategorie(): ?CategorieM
    {
        return $this->idcategorie;
    }

    public function setIdcategorie(?CategorieM $idcategorie): self
    {
        $this->idcategorie = $idcategorie;

        return $this;
    }

    public function getCategorie(): ?CategorieM
    {
        return $this->categorie;
    }

    public function setCategorie(?CategorieM $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    public function getCommandeM(): ?CommandeM
    {
        return $this->commandeM;
    }

    public function setCommandeM(?CommandeM $commandeM): self
    {
        $this->commandeM = $commandeM;

        return $this;
    }
}
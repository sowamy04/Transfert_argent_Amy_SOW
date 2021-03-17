<?php

namespace App\Entity;

use App\Entity\Agence;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CompteRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CompteRepository::class)
 * @ApiResource(
 *    attributes={
 *      "input_formats"={"json"={"application/ld+json", "application/json"}},
 *      "output_formats"={"json"={"application/ld+json", "application/json"}},
 *    },
 *  collectionOperations={
 *  "lister_comptes" = {
 *     "method" : "GET",
 *      "path":"/comptes",
 *      "normalization_context"={"groups":"compte:read"},
 *      "access_control"="(is_granted('ROLE_ADMIN'))",
 *      "access_control_message"="Vous n'avez pas access à cette Ressource",
 *  },
 * 
 *  "ajouter_compte" = {
 *     "method" : "POST",
 *      "path":"/admin/comptes",
 *      "normalization_context"={"groups":"compte:read"},
 *      "access_control"="(is_granted('ROLE_ADMIN'))",
 *      "access_control_message"="Vous n'avez pas access à cette Ressource",
 *   },
 * },
 * itemOperations={
 *  "afficher_compte" = {
 *     "method" : "GET",
 *      "path":"/admin/comptes/{id}",
 *      "normalization_context"={"groups":"compte:read"},
 *      "access_control"="(is_granted('ROLE_ADMIN'))",
 *      "access_control_message"="Vous n'avez pas access à cette Ressource",
 *  },
 *  "delete_compte" = {
 *     "method" : "DELETE",
 *      "path":"/admin/comptes/{id}",
 *      "normalization_context"={"groups":"compte:read"},
 *      "access_control"="(is_granted('ROLE_ADMIN'))",
 *      "access_control_message"="Vous n'avez pas access à cette Ressource",
 *  },
 *  "modifier_compte" = {
 *     "method" : "PUT",
 *      "path":"/admin/comptes/{id}",
 *      "normalization_context"={"groups":"compte:read"},
 *      "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_CAISSIER'))",
 *      "access_control_message"="Vous n'avez pas access à cette Ressource",
 *      "route_name":"update_compte"
 *  },
 * }
 * )
 */
class Compte
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"caissier:read", "agence:read", "compte:read", "transaction:read", "agence_part:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"caissier:read", "agence:read", "compte:read", "transaction:read", "agence_part:read"})
     */
    private $numero;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"caissier:read", "agence:read", "compte:read", "transaction:read", "agence_part:read"})
     */
    private $solde;

    /**
     * @ORM\Column(type="date")
     * @Groups({"caissier:read", "agence:read", "compte:read", "transaction:read", "agence_part:read"})
     */
    private $dateCreation;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"caissier:read", "agence:read", "compte:read", "transaction:read", "agence_part:read"})
     */
    private $statut = true;

    /**
     * @ORM\OneToOne(targetEntity=Agence::class, mappedBy="compte", cascade={"persist", "remove"})
     * @Groups({"compte:read"})
     */
    private $agence;

    /**
     * @ORM\ManyToOne(targetEntity=Caissier::class, inversedBy="comptes")
     * @Groups({"compte:read"})
     */
    private $caissier;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="compte")
     * @Groups({"compte:read", "agence_part:read"})
     */
    private $transactions;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
        $this->dateCreation = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getSolde(): ?int
    {
        return $this->solde;
    }

    public function setSolde(int $solde): self
    {
        $this->solde = $solde;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(bool $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getAgence(): ?Agence
    {
        return $this->agence;
    }

    public function setAgence(?Agence $agence): self
    {
        // unset the owning side of the relation if necessary
        if ($agence === null && $this->agence !== null) {
            $this->agence->setCompte(null);
        }

        // set the owning side of the relation if necessary
        if ($agence !== null && $agence->getCompte() !== $this) {
            $agence->setCompte($this);
        }

        $this->agence = $agence;

        return $this;
    }

    public function getCaissier(): ?Caissier
    {
        return $this->caissier;
    }

    public function setCaissier(?Caissier $caissier): self
    {
        $this->caissier = $caissier;

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions[] = $transaction;
            $transaction->setCompte($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getCompte() === $this) {
                $transaction->setCompte(null);
            }
        }

        return $this;
    }
}

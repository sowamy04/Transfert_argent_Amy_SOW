<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AgenceRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=AgenceRepository::class)
 * @ApiResource(
 *  collectionOperations={
 *  "lister_agences" = {
 *     "method" : "GET",
 *      "path":"/agences",
 *      "normalization_context"={"groups":"agence:read"},
 *      "access_control"="(is_granted('ROLE_ADMIN'))",
 *      "access_control_message"="Vous n'avez pas access à cette Ressource",
 *  },
 *  "ajouter_agence" = {
 *     "method" : "POST",
 *      "path":"/admin/agences",
 *      "normalization_context"={"groups":"agence:read"},
 *      "access_control"="(is_granted('ROLE_ADMIN'))",
 *      "access_control_message"="Vous n'avez pas access à cette Ressource",
 *      "route_name"="add_agence"
 *  },
 * },
 * itemOperations={
 *  "afficher_agence" = {
 *     "method" : "GET",
 *      "path":"/admin/agences/{id}",
 *      "normalization_context"={"groups":"agence:read"},
 *      "access_control"="(is_granted('ROLE_ADMIN'))",
 *      "access_control_message"="Vous n'avez pas access à cette Ressource",
 *  },
 * "afficher_parts_agence" = {
 *     "method" : "GET",
 *      "path":"/admin/agences/{id}/transactions",
 *      "normalization_context"={"groups":"agence_part:read"},
 *      "access_control"="(is_granted('ROLE_ADMIN_AGENCE'))",
 *      "access_control_message"="Vous n'avez pas access à cette Ressource",
 *  },
 *  "lister_users_agence" = {
 *     "method" : "GET",
 *      "path":"/admin_agence/agences/{id}/users",
 *      "normalization_context"={"groups":"agence_user:read"},
 *      "access_control"="(is_granted('ROLE_ADMIN'))",
 *      "access_control_message"="Vous n'avez pas access à cette Ressource",
 *  },
 *  "delete_agence" = {
 *     "method" : "DELETE",
 *      "path":"/admin/agences/{id}",
 *      "normalization_context"={"groups":"agence:read"},
 *      "access_control"="(is_granted('ROLE_ADMIN'))",
 *      "access_control_message"="Vous n'avez pas access à cette Ressource",
 *  },
 * }
 * )
 */
class Agence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"agence:read", "user_agence:read", "agence:read", "agence_user:read", "compte:read", "transaction:read",
     * "agence_part:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"agence:read", "user_agence:read", "agence:read", "agence_user:read", "compte:read", "transaction:read",
     * "agence_part:read"})
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"agence:read", "user_agence:read", "agence:read", "agence_user:read", "compte:read", "transaction:read",
     * "agence_part:read"})
     */
    private $adresse;

    /**
     * @ORM\Column(type="float")
     * @Groups({"agence:read", "user_agence:read", "agence:read", "agence_user:read", "compte:read", "transaction:read",
     * "agence_part:read"})
     */
    private $latitude;

    /**
     * @ORM\Column(type="float")
     * @Groups({"agence:read", "user_agence:read", "agence:read", "agence_user:read", "compte:read", "transaction:read",
     * "agence_part:read"})
     */
    private $longitude;


    /**
     * @ORM\OneToOne(targetEntity=Compte::class, inversedBy="agence", cascade={"persist", "remove"})
     * @Groups({"agence:read", "agence_part:read"})
     */
    private $compte;

    /**
     * @ORM\OneToMany(targetEntity=AdminAgence::class, mappedBy="agence")
     * @Groups({"agence:read"})
     */
    private $adminAgences;

    /**
     * @ORM\OneToMany(targetEntity=UserAgence::class, mappedBy="agence")
     * @Groups({"agence:read", "agence_user:read"})
     */
    private $userAgences;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"agence:read", "user_agence:read", "agence:read", "agence_user:read", "compte:read", "transaction:read"})
     */
    private $statut = true;

    public function __construct()
    {
        $this->adminAgences = new ArrayCollection();
        $this->userAgences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getCompte(): ?Compte
    {
        return $this->compte;
    }

    public function setCompte(?Compte $compte): self
    {
        $this->compte = $compte;

        return $this;
    }

    /**
     * @return Collection|AdminAgence[]
     */
    public function getAdminAgences(): Collection
    {
        return $this->adminAgences;
    }

    public function addAdminAgence(AdminAgence $adminAgence): self
    {
        if (!$this->adminAgences->contains($adminAgence)) {
            $this->adminAgences[] = $adminAgence;
            $adminAgence->setAgence($this);
        }

        return $this;
    }

    public function removeAdminAgence(AdminAgence $adminAgence): self
    {
        if ($this->adminAgences->removeElement($adminAgence)) {
            // set the owning side to null (unless already changed)
            if ($adminAgence->getAgence() === $this) {
                $adminAgence->setAgence(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|UserAgence[]
     */
    public function getUserAgences(): Collection
    {
        return $this->userAgences;
    }

    public function addUserAgence(UserAgence $userAgence): self
    {
        if (!$this->userAgences->contains($userAgence)) {
            $this->userAgences[] = $userAgence;
            $userAgence->setAgence($this);
        }

        return $this;
    }

    public function removeUserAgence(UserAgence $userAgence): self
    {
        if ($this->userAgences->removeElement($userAgence)) {
            // set the owning side to null (unless already changed)
            if ($userAgence->getAgence() === $this) {
                $userAgence->setAgence(null);
            }
        }

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
}

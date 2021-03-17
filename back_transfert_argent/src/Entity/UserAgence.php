<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserAgenceRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UserAgenceRepository::class)
 * @ApiResource(
 *      attributes={
 *      "input_formats"={"json"={"application/ld+json", "application/json"}},
 *      "output_formats"={"json"={"application/ld+json", "application/json"}},
 *      "deserialize"=false,
 *        "swagger_context"={
 *           "consumes"={
 *              "multipart/form-data",
 *             },
 *             "parameters"={
 *                "in"="formData",
 *                "name"="file",
 *                "type"="file",
 *                "description"="The file to upload",
 *              },
*           },
 *     },
 *  collectionOperations={
 *  "lister_user_agences" = {
 *     "method" : "GET",
 *      "path":"/user_agences",
 *      "normalization_context"={"groups":"user_agence:read"},
 *      "access_control"="(is_granted('ROLE_ADMIN) or is_granted('ROLE_ADMIN_AGENCE'))",
 *      "access_control_message"="Vous n'avez pas access à cette Ressource",
 *  },
 *  
 *  "ajouter_user_agence" = {
 *     "method" : "POST",
 *      "path":"/admin/user_agences",
 *      "normalization_context"={"groups":"user_agence:read"},
 *      "access_control"="(is_granted('ROLE_ADMIN'))",
 *      "access_control_message"="Vous n'avez pas access à cette Ressource",
 *      "route_name"="add_user_agence"
 *  },
 * },
 * itemOperations={
 *  "afficher_user_agence" = {
 *     "method" : "GET",
 *      "path":"/admin/user_agences/{id}",
 *      "normalization_context"={"groups":"user_agence:read"},
 *      "access_control"="(is_granted('ROLE_ADMIN'))",
 *      "access_control_message"="Vous n'avez pas access à cette Ressource",
 *  },
 * }
 * )
 */
class UserAgence extends User
{
    /**
     * @ORM\ManyToOne(targetEntity=Agence::class, inversedBy="userAgences")
     * @Groups({"user_agence:read", "transaction:read"})
     */
    private $agence;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="retraitUserAgence")
     */
    private $transactions;

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
            $transaction->setRetraitUserAgence($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getRetraitUserAgence() === $this) {
                $transaction->setRetraitUserAgence(null);
            }
        }

        return $this;
    }

    public function getAgence(): ?Agence
    {
        return $this->agence;
    }

    public function setAgence(?Agence $agence): self
    {
        $this->agence = $agence;

        return $this;
    }
}

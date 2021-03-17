<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CaissierRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CaissierRepository::class)
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
 *  "lister_caissiers" = {
 *     "method" : "GET",
 *      "path":"/caissiers",
 *      "normalization_context"={"groups":"caissier:read"},
 *      "access_control"="(is_granted('ROLE_ADMIN'))",
 *      "access_control_message"="Vous n'avez pas access à cette Ressource",
 *  },
 * 
 *  "ajouter_caissier" = {
 *     "method" : "POST",
 *      "path":"/admin/caissiers",
 *      "normalization_context"={"groups":"caissier:read"},
 *      "access_control"="(is_granted('ROLE_ADMIN'))",
 *      "access_control_message"="Vous n'avez pas access à cette Ressource",
 *      "route_name"="add_caissier"
 *  },
 * },
 * itemOperations={
 *  "afficher_caissier" = {
 *     "method" : "GET",
 *      "path":"/admin/caissiers/{id}",
 *      "normalization_context"={"groups":"caissier:read"},
 *      "access_control"="(is_granted('ROLE_ADMIN'))",
 *      "access_control_message"="Vous n'avez pas access à cette Ressource",
 *  },
 * }
 * )
 */
class Caissier extends User
{
    /**
     * @ORM\OneToMany(targetEntity=Compte::class, mappedBy="caissier")
     * @Groups({"caissier:read"})
     */
    private $comptes;

    public function __construct()
    {
        $this->comptes = new ArrayCollection();
    }

    /**
     * @return Collection|Compte[]
     */
    public function getComptes(): Collection
    {
        return $this->comptes;
    }

    public function addCompte(Compte $compte): self
    {
        if (!$this->comptes->contains($compte)) {
            $this->comptes[] = $compte;
            $compte->setCaissier($this);
        }

        return $this;
    }

    public function removeCompte(Compte $compte): self
    {
        if ($this->comptes->removeElement($compte)) {
            // set the owning side to null (unless already changed)
            if ($compte->getCaissier() === $this) {
                $compte->setCaissier(null);
            }
        }

        return $this;
    }
}

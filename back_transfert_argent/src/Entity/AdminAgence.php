<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AdminAgenceRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=AdminAgenceRepository::class)
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
 *  "lister_admin_agences" = {
 *     "method" : "GET",
 *      "path":"/admin_agences",
 *      "normalization_context"={"groups":"admin_agence:read"},
 *      "access_control"="(is_granted('ROLE_ADMIN'))",
 *      "access_control_message"="Vous n'avez pas access à cette Ressource",
 *  },
 * 
 *  "ajouter_admin_agence" = {
 *     "method" : "POST",
 *      "path":"/admin/admin_agences",
 *      "normalization_context"={"groups":"admin_agence:read"},
 *      "access_control"="(is_granted('ROLE_ADMIN'))",
 *      "access_control_message"="Vous n'avez pas access à cette Ressource",
 *      "route_name"="add_admin_agence"
 *  },
 * },
 * itemOperations={
 *  "afficher_admin_agence" = {
 *     "method" : "GET",
 *      "path":"/admin/admin_agences/{id}",
 *      "normalization_context"={"groups":"admin_agence:read"},
 *      "access_control"="(is_granted('ROLE_ADMIN'))",
 *      "access_control_message"="Vous n'avez pas access à cette Ressource",
 *  },
 * }
 * )
 */
class AdminAgence extends User
{
    /**
     * @ORM\ManyToOne(targetEntity=Agence::class, inversedBy="adminAgences")
     * @Groups({"admin_agence:read"})
     */
    private $agence;

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

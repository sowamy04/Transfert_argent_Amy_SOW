<?php

namespace App\Entity;

use App\Entity\Admin;
use App\Entity\Profil;
use App\Entity\Caissier;
use App\Entity\UserAgence;
use App\Entity\AdminAgence;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="profil", type="string")
 * @ORM\DiscriminatorMap({"admin"="Admin", "caissier"="Caissier", "admin_agence"="AdminAgence", "user_agence"="UserAgence", "user"="User"})
 * @ApiResource(
 * attributes={
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
 *  "get"
 * },
 * 
 * itemOperations={
 * "get",
 *  "archiver_profil" = {
 *     "method" : "DELETE",
 *      "path":"admin/users/{id}",
 *      "normalization_context"={"groups":"user:read"},
 *      "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_ADMIN_AGENCE'))",
 *      "access_control_message"="Vous n'avez pas access à cette Ressource",
 *  },
 * 
 *  "modifier_user" = {
 *     "method" : "PUT",
 *      "path":"/admin/users/{id}",
 *      "normalization_context"={"groups":"user:read"},
 *      "access_control"="(is_granted('ROLE_ADMIN'))",
 *      "access_control_message"="Vous n'avez pas access à cette Ressource",
 *      "route_name"="update_user",
 *  },
 * }
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"profil:read", "admin:read", "user:read", "caissier:read", "admin_agence:read", 
     * "user_agence:read", "agence:read", "agence_user:read", "compte:read", "transaction:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"profil:read", "admin:read", "user:read", "caissier:read", "admin_agence:read", 
     * "user_agence:read", "agence:read", "agence_user:read", "compte:read", "transaction:read"})
     */
    private $email;

    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"profil:read", "admin:read", "user:read", "caissier:read", "admin_agence:read", 
     * "user_agence:read", "agence:read", "agence_user:read", "compte:read", "transaction:read"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"profil:read", "admin:read", "user:read", "caissier:read", "admin_agence:read", 
     * "user_agence:read", "agence:read", "agence_user:read", "compte:read", "transaction:read"})
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"profil:read", "admin:read", "user:read", "caissier:read", "admin_agence:read", 
     * "user_agence:read", "agence:read", "agence_user:read", "compte:read", "transaction:read"})
     */
    private $telephone;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"profil:read", "admin:read", "user:read", "caissier:read", "admin_agence:read", 
     * "user_agence:read", "agence:read", "agence_user:read", "compte:read", "transaction:read"})
     */
    private $statut;

    /**
     * @ORM\ManyToOne(targetEntity=Profil::class, inversedBy="users")
     */
    private $profil;

    /**
     * @ORM\Column(type="blob", nullable=true)
     * @Groups({"profil:read", "admin:read", "user:read", "caissier:read", "admin_agence:read", 
     * "user_agence:read", "agence:read", "agence_user:read", "compte:read", "transaction:read"})
     */
    private $photo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_'.$this->profil->getLibelle();

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
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

    public function getStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(bool $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getProfil(): ?Profil
    {
        return $this->profil;
    }

    public function setProfil(?Profil $profil): self
    {
        $this->profil = $profil;

        return $this;
    }

    public function getPhoto()
    {
        if ($this->photo != null) {
            return base64_encode(stream_get_contents($this->photo));
        }
        else{
            $this->photo;
        }
    }

    public function setPhoto($photo): self
    {
        $this->photo = $photo;

        return $this;
    }
}

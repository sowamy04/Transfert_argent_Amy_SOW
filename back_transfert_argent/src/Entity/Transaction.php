<?php

namespace App\Entity;

use App\Entity\Compte;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TransactionRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 * @ApiResource(
 *   attributes={
 *      "input_formats"={"json"={"application/ld+json", "application/json"}},
 *      "output_formats"={"json"={"application/ld+json", "application/json"}},
 *    },
 *  collectionOperations={
 *  "lister_transactions" = {
 *     "method" : "GET",
 *      "path":"/transactions",
 *      "normalization_context"={"groups":"transaction:read"},
 *      "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_ADMIN_AGENCE') or is_granted('ROLE_USER_AGENCE'))",
 *      "access_control_message"="Vous n'avez pas access à cette Ressource",
 *  },
 *  "lister_part_agence" = {
 *     "method" : "GET",
 *      "path":"/transactions/agences",
 *      "normalization_context"={"groups":"trans_agence:read"},
 *      "access_control"="(is_granted('ROLE_ADMIN_AGENCE'))",
 *      "access_control_message"="Vous n'avez pas access à cette Ressource",
 *  },
 *  "lister_part_etat" = {
 *     "method" : "GET",
 *      "path":"/transactions/etat",
 *      "normalization_context"={"groups":"trans_etat:read"},
 *      "access_control"="(is_granted('ROLE_ADMIN'))",
 *      "access_control_message"="Vous n'avez pas access à cette Ressource",
 *  },
 *  "ajouter_transaction" = {
 *     "method" : "POST",
 *      "path":"/user_agences/transactions",
 *      "normalization_context"={"groups":"transaction:read"},
 *      "access_control"="(is_granted('ROLE_ADMIN_AGENCE') or is_granted('ROLE_USER_AGENCE'))",
 *      "access_control_message"="Vous n'avez pas access à cette Ressource",
 *      "route_name"="add_transaction"
 *   },
 * },
 * itemOperations={
 *  "afficher_transaction" = {
 *     "method" : "GET",
 *      "path":"/admin/transactions/{id}",
 *      "normalization_context"={"groups":"transaction:read"},
 *      "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_ADMIN_AGENCE') or is_granted('ROLE_USER_AGENCE'))",
 *      "access_control_message"="Vous n'avez pas access à cette Ressource",
 *  },
 *  "delete_transaction" = {
 *     "method" : "DELETE",
 *      "path":"/admin/transactions/{id}",
 *      "normalization_context"={"groups":"transaction:read"},
 *      "access_control"="(is_granted('ROLE_ADMIN'))",
 *      "access_control_message"="Vous n'avez pas access à cette Ressource",
 *  },
 *  "modifier_transaction" = {
 *     "method" : "PUT",
 *      "path":"/user_agences/transactions/{id}",
 *      "normalization_context"={"groups":"transaction:read"},
 *      "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_ADMIN_AGENCE'))",
 *      "access_control_message"="Vous n'avez pas access à cette Ressource",
 *      "route_name":"update_transaction"
 *  },
 * }
 * )
 */
class Transaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"compte:read", "transaction:read", "trans_etat:read", "trans_agence:read", "agence_part:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"compte:read", "transaction:read", "trans_etat:read", "trans_agence:read", "agence_part:read"})
     */
    private $montant;

    /**
     * @ORM\Column(type="date")
     * @Groups({"compte:read", "transaction:read", "trans_etat:read", "trans_agence:read", "agence_part:read"})
     */
    private $dateDepot;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"compte:read", "transaction:read", "trans_etat:read", "trans_agence:read", "agence_part:read"})
     */
    private $dateRetrait;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"compte:read", "transaction:read"})
     */
    private $code;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"compte:read", "transaction:read", "trans_etat:read", "trans_agence:read", "agence_part:read"})
     */
    private $frais;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"transaction:read", "trans_agence:read", "agence_part:read"})
     */
    private $fraisDepot;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"compte:read", "transaction:read", "trans_agence:read", "agence_part:read"})
     */
    private $fraisRetrait;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"transaction:read", "trans_etat:read"})
     */
    private $fraisEtat;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"transaction:read"})
     */
    private $fraisSysteme;

    /**
     * @ORM\ManyToOne(targetEntity=Compte::class, inversedBy="transactions")
     * @Groups({"transaction:read"})
     */
    private $compte;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="transactions")
     * @Groups({"transaction:read"})
     */
    private $retraitClient;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="transactions")
     * @Groups({"transaction:read"})
     */
    private $depotClient;

    /**
     * @ORM\ManyToOne(targetEntity=UserAgence::class, inversedBy="transactions")
     * @Groups({"transaction:read"})
     */
    private $retraitUserAgence;

    /**
     * @ORM\ManyToOne(targetEntity=UserAgence::class, inversedBy="transactions")
     * @Groups({"transaction:read"})
     */
    private $depotUserAgence;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getDateDepot(): ?\DateTimeInterface
    {
        return $this->dateDepot;
    }

    public function setDateDepot(\DateTimeInterface $dateDepot): self
    {
        $this->dateDepot = $dateDepot;

        return $this;
    }

    public function getDateRetrait(): ?\DateTimeInterface
    {
        return $this->dateRetrait;
    }

    public function setDateRetrait(?\DateTimeInterface $dateRetrait): self
    {
        $this->dateRetrait = $dateRetrait;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getFrais(): ?int
    {
        return $this->frais;
    }

    public function setFrais(int $frais): self
    {
        $this->frais = $frais;

        return $this;
    }

    public function getFraisDepot(): ?int
    {
        return $this->fraisDepot;
    }

    public function setFraisDepot(int $fraisDepot): self
    {
        $this->fraisDepot = $fraisDepot;

        return $this;
    }

    public function getFraisRetrait(): ?int
    {
        return $this->fraisRetrait;
    }

    public function setFraisRetrait(int $fraisRetrait): self
    {
        $this->fraisRetrait = $fraisRetrait;

        return $this;
    }

    public function getFraisEtat(): ?int
    {
        return $this->fraisEtat;
    }

    public function setFraisEtat(int $fraisEtat): self
    {
        $this->fraisEtat = $fraisEtat;

        return $this;
    }

    public function getFraisSysteme(): ?int
    {
        return $this->fraisSysteme;
    }

    public function setFraisSysteme(int $fraisSysteme): self
    {
        $this->fraisSysteme = $fraisSysteme;

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

    public function getRetraitClient(): ?Client
    {
        return $this->retraitClient;
    }

    public function setRetraitClient(?Client $retraitClient): self
    {
        $this->retraitClient = $retraitClient;

        return $this;
    }

    public function getDepotClient(): ?Client
    {
        return $this->depotClient;
    }

    public function setDepotClient(?Client $depotClient): self
    {
        $this->depotClient = $depotClient;

        return $this;
    }

    public function getRetraitUserAgence(): ?UserAgence
    {
        return $this->retraitUserAgence;
    }

    public function setRetraitUserAgence(?UserAgence $retraitUserAgence): self
    {
        $this->retraitUserAgence = $retraitUserAgence;

        return $this;
    }

    public function getDepotUserAgence(): ?UserAgence
    {
        return $this->depotUserAgence;
    }

    public function setDepotUserAgence(?UserAgence $depotUserAgence): self
    {
        $this->depotUserAgence = $depotUserAgence;

        return $this;
    }
}

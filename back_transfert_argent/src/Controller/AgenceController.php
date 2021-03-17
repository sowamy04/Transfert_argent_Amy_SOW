<?php

namespace App\Controller;

use App\Entity\Agence;
use App\Entity\Compte;
use App\Entity\AdminAgence;
use App\Entity\UserAgence;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AgenceController extends AbstractController
{
    private $encode;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encode = $encoder;
    }

    /**
     * @Route(
     * path="/api/admin/agences",
     *  name="add_agence",
     *  methods={"POST"},
     *  defaults={
     *      "_controller"="\app\ControllerAgenceController::ajouter_agence",
     *      "_api_resource_class"=Agence::class,
     *      "_api_collection_operation_name"="ajouter_agence",
     *  }
     * )
     */
    public function ajouter_agence( Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $agenceJson = $request->getContent();
        $agenceInfo = json_decode($agenceJson,true);
        if ($agenceInfo['comptes']['solde'] < 700000) {
           return new JsonResponse("Le solde doit être supérieur ou égale à 700.000 F CFA");
        }
        else {
            $compte = new Compte();
            $compte->setNumero($agenceInfo['comptes']['numero'])
                ->setSolde($agenceInfo['comptes']['solde'])
                ->setDateCreation(new \DateTime($agenceInfo['comptes']['dateCreation']))
            ;
            $em->persist($compte);

            $agence = new Agence();
            $agence->setTelephone($agenceInfo['telephone'])
                ->setAdresse($agenceInfo['adresse'])
                ->setLatitude($agenceInfo['latitude'])
                ->setLongitude($agenceInfo['longitude'])
                ->setCompte($compte)
            ;
            $em->persist($agence);

            $admin = new AdminAgence();
            $admin->setAgence($agence)
                ->setPrenom($agenceInfo['adminAgence']['prenom'])
                ->setNom($agenceInfo['adminAgence']['nom'])
                ->setEmail($agenceInfo['adminAgence']['email'])
                ->setTelephone($agenceInfo['adminAgence']['telephone'])
                ->setPassword($this->encode->encodePassword($admin, $agenceInfo['adminAgence']['password']))
            ;
            $em->persist($admin);

            $user = new UserAgence();
            $user->setAgence($agence)
                ->setPrenom($agenceInfo['userAgence']['prenom'])
                ->setNom($agenceInfo['userAgence']['nom'])
                ->setEmail($agenceInfo['userAgence']['email'])
                ->setTelephone($agenceInfo['userAgence']['telephone'])
                ->setPassword($this->encode->encodePassword($user, $agenceInfo['userAgence']['password']))
            ;
            $em->persist($user);
            return $this->json("Agence ajouté avec succès avec un compte, un admin et un utilisateur!", 201);
        }
    }
}

<?php

namespace App\Controller;

use App\Entity\Compte;
use App\Repository\CompteRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CompteController extends AbstractController
{
    /**
     * @Route(
     * path="/api/admin/comptes/{id}",
     *  name="update_compte",
     *  methods={"PUT"},
     *  defaults={
     *      "_controller"="\app\ControllerCompteController::modifier_compte",
     *      "_api_resource_class"=Compte::class,
     *      "_api_collection_operation_name"="modifier_compte",
     *  }
     * )
     */
    public function modifier_compte(int $id, Request $request, CompteRepository $compteRepo, TokenStorageInterface $tokenStorage)
    {
        $em = $this->getDoctrine()->getManager();
        $caissier = $tokenStorage->getToken()->getUser();
        $compteJson = $request->getContent();
        $compteInfo = json_decode($compteJson,true);
        $compte = $compteRepo->findOneBy(["id"=>$id]);
        $solde = $compte->getSolde();
        if ($caissier->getProfil()->getLibelle() == "CAISSIER") {
            if($compteInfo['action'] == "depot"){
                $compte->setNumero($compteInfo['numero'])
                   ->setSolde($solde + $compteInfo['montant'])
                   ->setDateCreation(new \DateTime($compteInfo['dateCreation']))
                   ->setCaissier($caissier)
                   ;
            }
            else if($compteInfo['action'] == "retrait"){
                $compte->setNumero($compteInfo['numero'])
                   ->setSolde($solde - $compteInfo['montant'])
                   ->setDateCreation(new \DateTime($compteInfo['dateCreation']))
                   ->setCaissier($caissier)
                   ;
            }
        }

        else{
            if($compteInfo['action'] == "depot"){
                $compte->setNumero($compteInfo['numero'])
                   ->setSolde($solde + $compteInfo['montant'])
                   ->setDateCreation(new \DateTime($compteInfo['dateCreation']))
                   ;
            }
            else if($compteInfo['action'] == "retrait"){
                $compte->setNumero($compteInfo['numero'])
                   ->setSolde($solde - $compteInfo['montant'])
                   ->setDateCreation(new \DateTime($compteInfo['dateCreation']))
                   ;
            }
        }
        
        
        $em->flush();
        return $this->json("Compte modifié avec succès!");
    }
}

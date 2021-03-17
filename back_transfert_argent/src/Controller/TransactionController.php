<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Repository\ClientRepository;
use App\Repository\CompteRepository;
use App\Repository\TransactionRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class TransactionController extends AbstractController
{
    /**
     * @Route(
     * path="/api/user_agences/transactions",
     *  name="add_transaction",
     *  methods={"POST"},
     *  defaults={
     *      "_controller"="\app\ControllerTransactionController::depot",
     *      "_api_resource_class"=Transaction::class,
     *      "_api_collection_operation_name"="ajouter_transaction",
     *  }
     * )
     */
    public function depot( Request $request, TokenStorageInterface $tokenStorage, ClientRepository $clientRepo, CompteRepository $compteRepository)
    {
        $em = $this->getDoctrine()->getManager();
        $userAgence = $tokenStorage->getToken()->getUser();
        $transJson = $request->getContent();
        $transInfo = json_decode($transJson,true);
        $frais = $this->frais($transInfo['montant']);
        $random = random_int(100000000, 999999999);
        
        if ($frais == 0) {
            return new JsonResponse("Le montant ne peut pas être négatif");
        }
        else{
            $faisEtat = ($frais *40)/100;
            $fraisSysteme = ($frais *30)/100;
            $fraisDepot = ($frais *10)/100;
            $fraisRetrait = ($frais *20)/100;
            $compteAgence = $userAgence->getAgence()->getCompte();
            if ($userAgence->getProfil()->getLibelle() == 'USER_AGENCE') {
                if ($compteAgence->getSolde() > $transInfo['montant']) {
                    $depot= new Transaction();
                    $clients =$clientRepo->findAll();
                    foreach ($clients as $key => $client) {
                        if ($client->getNumeroCni() == $transInfo['clientD']) {
                            $depot->setDepotClient($client);
                        }
                        if($client->getNumeroCni() == $transInfo['clientR']){
                            $depot->setRetraitClient($client);
                        }
                    }
                    $comptes = $compteRepository->findAll();
                    foreach ($comptes as $key => $compte) {
                        if ($compte->getNumero() == "123456789009") {
                            $compteAgence->setSolde($compteAgence->getSolde() - ($transInfo['montant'] + $fraisRetrait+ $fraisSysteme+ $faisEtat));
                            $compte->setSolde($compte->getSolde() + $transInfo['montant']+ $fraisRetrait+ $fraisSysteme);
                            $depot->setMontant($transInfo['montant'])
                                  ->setDateDepot(new \DateTime())
                                  ->setFrais($frais)
                                  ->setFraisDepot($fraisDepot)
                                  ->setFraisRetrait($fraisRetrait)
                                  ->setFraisEtat($faisEtat)
                                  ->setFraisSysteme($fraisSysteme)
                                  ->setDepotUserAgence($userAgence)
                                  ->setCode($random)
                                  ->setCompte($compte)
                            ;
                            $em->persist($depot);
                            $em->flush();
                            return $this->json("Dépôt éffectué avec succès!");
                        }
                    }
                }
            }
            else{
                if ($compteAgence->getSolde() > $transInfo['montant']) {
                    $depot= new Transaction();
                    $clients =$clientRepo->findAll();
                    foreach ($clients as $key => $client) {
                        if ($client->getNumeroCni() == $transInfo['clientD']) {
                            $depot->setDepotClient($client);
                        }
                        if($client->getNumeroCni() == $transInfo['clientR']){
                            $depot->setRetraitClient($client);
                        }
                    }
                    $comptes = $compteRepository->findAll();
                    foreach ($comptes as $key => $compte) {
                        if ($compte->getNumero() == "123456789009") {
                            $compteAgence->setSolde($compteAgence->getSolde() - ($transInfo['montant'] + $fraisRetrait+ $fraisSysteme+ $faisEtat));
                            $compte->setSolde($compte->getSolde() + $transInfo['montant']+ $fraisRetrait+ $fraisSysteme);
                            $depot->setMontant($transInfo['montant'])
                                  ->setDateDepot(new \DateTime())
                                  ->setFrais($frais)
                                  ->setFraisDepot($fraisDepot)
                                  ->setFraisRetrait($fraisRetrait)
                                  ->setFraisEtat($faisEtat)
                                  ->setFraisSysteme($fraisSysteme)
                                  ->setCode($random)
                                  ->setCompte($compte)
                            ;
                            $em->persist($depot);
                            $em->flush();
                            return $this->json("Dépôt éffectué avec succès!");
                        }
                    }
                }
            }
        }

    }


    /**
     * @Route(
     * path="/api/user_agences/transactions/{id}",
     *  name="update_transaction",
     *  methods={"PUT"},
     *  defaults={
     *      "_controller"="\app\ControllerTransactionController::retrait",
     *      "_api_resource_class"=Transaction::class,
     *      "_api_collection_operation_name"="modifier_transaction",
     *  }
     * )
     */
    public function retrait(int $id, Request $request, TokenStorageInterface $tokenStorage, TransactionRepository $transRepo, ClientRepository $clientRepo, CompteRepository $compteRepository)
    {
        $em = $this->getDoctrine()->getManager();
        $userAgence = $tokenStorage->getToken()->getUser();
        $transJson = $request->getContent();
        $transInfo = json_decode($transJson,true);
        $retrait = $transRepo->findOneBy(["id"=>$id]);
        if($retrait->getCode() == $transInfo['code']){
            $compteAgence = $userAgence->getAgence()->getCompte();
            if ($userAgence->getProfil()->getLibelle() == 'USER_AGENCE') {
                $clients =$clientRepo->findAll();
                foreach ($clients as $key => $client) {
                    if($client->getNumeroCni() == $transInfo['clientR']){
                        $comptes = $compteRepository->findAll();
                        foreach ($comptes as $key => $compte) {
                            if ($compte->getNumero() == "123456789009") {
                                $montantFrais= $retrait->getMontant()+ $retrait->getFraisRetrait();
                                $compte->setSolde($compte->getSolde() - $montantFrais);
                                $compteAgence->setSolde($compteAgence->getSolde() + $montantFrais);
                                $retrait->setDateRetrait(new \DateTime())
                                        ->setRetraitUserAgence($userAgence)
                                ;
                                $em->flush();
                                return $this->json("Retrait éffectué avec succès!");
                            }
                        }
                    }
                }
            }
            else{
                $clients =$clientRepo->findAll();
                foreach ($clients as $key => $client) {
                    if($client->getNumeroCni() == $transInfo['clientR']){
                        $comptes = $compteRepository->findAll();
                        foreach ($comptes as $key => $compte) {
                            if ($compte->getNumero() == "123456789009") {
                                $montantFrais= $retrait->getMontant()+ $retrait->getFraisRetrait();
                                $compte->setSolde($compte->getSolde() - $montantFrais);
                                $compteAgence->setSolde($compteAgence->getSolde() + $montantFrais);
                                $retrait->setDateRetrait(new \DateTime());
                                $em->flush();
                                return $this->json("Retrait éffectué avec succès!");
                            }
                        }
                    }
                }
            }
        }
        else{
            return $this->json("Code invalide!");
        }
        
    }


    public function frais($montant){
        //$frais = 0;
        if ($montant>=0 and $montant<=5000) {
            $frais = 425;
        }
        else if($montant>=5001 and $montant<=10000){
            $frais = 850;
        }
        else if($montant>=10001 and $montant<=15000){
            $frais =1270;
        }
        else if($montant>=15001 and $montant<=20000){
            $frais=1695;
        }
        else if($montant>=20001 and $montant<=50000){
            $frais = 2500;
        }
        else if($montant>=50001 and $montant<=60000){
            $frais= 3000 ;
        }
        else if($montant>=60001 and $montant<=75000){
            $frais= 4000 ;
        }
        else if($montant>=75001 and $montant<=120000){
            $frais= 5000 ;
        }
        else if($montant>=120001 and $montant<=150000){
            $frais= 6000 ;
        }
        else if($montant>=150001 and $montant<=200000){
            $frais= 7000 ;
        }
        else if($montant>=200001 and $montant<=250000){
            $frais= 8000 ;
        }
        else if($montant>=250001 and $montant<=300000){
            $frais= 9000 ;
        }
        else if($montant>=300001 and $montant<=400000){
            $frais= 12000 ;
        }
        else if($montant>=400001 and $montant<=750000){
            $frais= 15000 ;
        }
        else if($montant>=750000 and $montant<=900000){
            $frais= 22000 ;
        }
        else if($montant>=900001 and $montant<=1000000){
            $frais= 25000 ;
        }
        else if($montant>=1000001 and $montant<=1125000){
            $frais= 27000 ;
        }
        else if($montant>=1125001 and $montant<=2000000){
            $frais= 30000 ;
        }
        else if($montant>2000000){
            $frais = ($montant*2)/100;
        }
        else{
            $frais = 0;
        }
        return $frais;
    }
}

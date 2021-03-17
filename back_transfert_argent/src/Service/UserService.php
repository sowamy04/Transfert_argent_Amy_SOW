<?php

namespace App\Service;

use App\Entity\Agence;
use App\Entity\Profil;
use App\Entity\User;
use App\Repository\ApprenantRepository;
use App\Repository\UserRepository;
use App\Repository\ProfilRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService {
    private $dn;
    private $encode;
    private $userRepository;
    private $manage;
    public function __construct(UserPasswordEncoderInterface $encoder, DenormalizerInterface $denormalize, 
    UserRepository $userRepository, EntityManagerInterface $manager, ProfilRepository $profilRepository)
    {
        $this->dn = $denormalize;
        $this->encode = $encoder;
        $this->userRepository = $userRepository;
        $this->manage = $manager;
        $this->profilRepository = $profilRepository;
    }

    public function ajout_utilisateur($request, $pf){
        $requete = $request->request->all();
        $photo= $request->files->get('photo');
        if ($photo) {
            $photo= fopen($photo->getRealPath(),"rb");
        }
        $profilTab = $this->manage->getRepository(Profil::class)->findAll();
        $agenceReq="";
        foreach ($profilTab as $profil) {
            if ($profil->getLibelle() == $pf) {
                if ($pf == "ADMIN") {
                    $class="App\\Entity\\Admin";
                }
                elseif ($pf == "CAISSIER") {
                    $class="App\\Entity\\Caissier";
                }
                elseif ($pf == "ADMIN_AGENCE") {
                    $class="App\\Entity\\AdminAgence";
                    if($requete['agences']){
                        $agenceTab = $this->manage->getRepository(Agence::class)->findAll();
                        foreach ($agenceTab as $agence) {
                            if ($agence->getId() == (int)$requete['agences']) {
                                $agenceReq=$agence;
                            }
                        }
                    }
                    
                }
                elseif ($pf == "USER_AGENCE"){
                    $class="App\\Entity\\UserAgence";
                    if($requete['agences']){
                        $agenceTab = $this->manage->getRepository(Agence::class)->findAll();
                        foreach ($agenceTab as $agence) {
                            if ($agence->getId() == (int)$requete['agences']) {
                                $agenceReq=$agence;
                            }
                        }
                    }
                }
                $requete = $this->dn->denormalize($requete, $class, null);
                $requete->setPassword($this->encode->encodePassword($requete, $requete->getPassword()));
                $requete->setProfil($profil);
                $requete->setStatut(true);
                $requete->setPhoto($photo);
                if ($agenceReq) {
                    $requete->setAgence($agenceReq);
                }
                $this->manage->persist($requete);
                $this->manage->flush();  
                return true;
            }

        }
    }

    public function modification_user($request, $id)
    {
        $user = $this->userRepository->findOneBy(["id"=>$id]);
        if ($user) {
            $requete = $request->request->all();
            $prenom = $requete['prenom'];
            $nom = $requete['nom'];
            $email = $requete['email'];
            $password = $requete['password'];
            $telephone = $requete['telephone'];
            $photo= $request->files->get('photo');
            if ($photo) {
                $photo= fopen($photo->getRealPath(),"rb");
            }
            
            $user
                ->setPrenom($prenom)
                ->setNom($nom)
                ->setTelephone($telephone)
                ->setEmail($email)
                ->setStatut(true)
                ->setPhoto($photo)
                ->setPassword($this->encode->encodePassword($user, $password));
            
            $this->manage->flush();
            return true;
        }
        
    }

    
}
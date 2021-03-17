<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Admin;
use App\Entity\AdminAgence;
use App\Entity\Agence;
use App\Entity\Caissier;
use App\Entity\Client;
use App\Entity\Compte;
use App\Entity\Profil;
use App\Entity\Transaction;
use App\Entity\UserAgence;
use DateTime;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\Date;

class AppFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder=$encoder;
    }
    
    public function load(ObjectManager $manager)
    {
        $faker= Factory::create();
        $profils =["ADMIN", "CAISSIER", "ADMIN_AGENCE" ,"USER_AGENCE"];  
        
        foreach ($profils as $libelle) {
            $profil =new Profil() ;
            $profil->setLibelle ($libelle );
            $manager->persist ($profil );
            $manager->flush();

            if($profil->getLibelle() == "ADMIN"){
                  $admin = new Admin() ;
                  $password = $this->encoder->encodePassword ($admin, 'pass1234' );
                  $admin->setProfil ($profil )
                        ->setPassword($password )
                        ->setPrenom($faker->firstName())
                        ->setNom($faker->lastName)
                        ->setEmail("admin"."@gmail.com")
                        ->setTelephone($faker->phoneNumber)
                        ->setStatut(true)
                        ;
                  $manager->persist($admin);
                  
            }

            if($profil->getLibelle() == "CAISSIER"){
                for ($i=1; $i <=2 ; $i++) {
                    $caissier = new Caissier() ;
                    $password = $this->encoder->encodePassword ($caissier, 'pass1234' );
                    $caissier->setProfil ($profil )
                        ->setPassword($password )
                        ->setPrenom($faker->firstName())
                        ->setNom($faker->lastName)
                        ->setEmail("caissier".$i."@gmail.com")
                        ->setTelephone($faker->phoneNumber)
                        ->setStatut(true)
                        ;
                    $manager->persist($caissier);
                    $compte = new Compte();
                    $compte->setNumero("434048972590889"+$i)
                           ->setDateCreation($faker->dateTimeBetween('now', '+2 years'))
                           ->setSolde($i + 10000000)
                           ->setStatut(true)
                           ->setCaissier($caissier)
                    ;
                    $manager->persist($compte);
                }
            }

            if($profil->getLibelle()  == "ADMIN_AGENCE"){
                  for ($i=1; $i <=2 ; $i++) {
                  $admin_agence = new AdminAgence() ;
                  $password = $this->encoder->encodePassword ($admin_agence, 'pass1234' );
                  $admin_agence->setProfil ($profil )
                        ->setPassword($password )
                        ->setPrenom($faker->firstName())
                        ->setNom($faker->lastName)
                        ->setEmail("adminagence".$i."@gmail.com")
                        ->setTelephone($faker->phoneNumber)
                        ->setStatut(true)
                        ;
                    $agence = new Agence();
                    $agence->setTelephone($faker->phoneNumber)
                           ->setLatitude($faker->latitude)
                           ->setLongitude($faker->longitude)
                           ->setAdresse($faker->address)
                    ;
                    $manager->persist($agence);
                    $admin_agence->setAgence($agence);
                  $manager->persist($admin_agence);
                  }
            }

            if($profil->getLibelle()  == "USER_AGENCE"){
                $agence = new Agence();
                $agence->setTelephone($faker->phoneNumber)
                        ->setLatitude($faker->latitude)
                        ->setLongitude($faker->longitude)
                        ->setAdresse($faker->address)
                ;
                $manager->persist($agence);

                  for ($i=1; $i <=2 ; $i++) {
                  $user = new UserAgence() ;
                  $password = $this->encoder->encodePassword ($user, 'pass1234' );
                  $user ->setAgence($agence)
                        ->setProfil ($profil )
                        ->setPassword($password )
                        ->setPrenom($faker->firstName())
                        ->setNom($faker->lastName)
                        ->setEmail("useragence".$i."@gmail.com")
                        ->setTelephone($faker->phoneNumber)
                        ->setStatut(true)
                        ;
                  $manager->persist($user);
                  }
            }
        }

        for ($i=0; $i <20 ; $i++) { 
            $client = new Client();
            $client->setNomComplet($faker->name)
                ->setTelephone($faker->phoneNumber)
            ;
            if ($i<10) {
                $client->setNumeroCni("287619950000"+$i);
            }
            else{
                $client->setNumeroCni("11381986001"+$i); 
            }
        }

        for ($i=0; $i < 2; $i++) { 
            $transaction = new Transaction();
            $transaction->setMontant(10000)
                        ->setDateDepot(new DateTime())
                        ->setCode("123456789")
                        ->setFrais(500)
                        ->setFraisDepot(50)
                        ->setFraisRetrait(100)
                        ->setFraisSysteme(150)
                        ->setFraisEtat(200)
                        ->setDepotUserAgence($user)
                        ->setDepotClient($client)
                        ->setCompte($compte)
            ;
        }

        $manager->flush();
    }
}

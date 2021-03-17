<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Admin;
use App\Entity\Caissier;
use App\Entity\UserAgence;
use App\Entity\AdminAgence;
use App\Service\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{

    private $userService;

    public function __construct(UserService $userService) 
    {
        $this->userService = $userService;
    }

    /**
     * @Route(
     * path="/api/admin",
     *  name="add_admin",
     *  methods={"POST"},
     *  defaults={
     *      "_controller"="\app\ControllerApiController::ajouter_admin",
     *      "_api_resource_class"=Admin::class,
     *      "_api_collection_operation_name"="ajouter_admin",
     *  }
     * )
     */
    public function ajouter_admin( Request $request)
    {
        $profil="ADMIN";
        if($this->userService->ajout_utilisateur($request, $profil)){
            return $this->json("Admin ajouté avec succès!", 201);
        }
        return $this->json("Erreur lors de l'insertion!",400); 
    }


    /**
     * @Route(
     * path="/api/admin/caissiers",
     *  name="add_caissier",
     *  methods={"POST"},
     *  defaults={
     *      "_controller"="\app\ControllerApiController::ajouter_caissier",
     *      "_api_resource_class"=Caissier::class,
     *      "_api_collection_operation_name"="ajouter_caissier",
     *  }
     * )
     */
    public function ajouter_caissier( Request $request)
    {
        $profil="CAISSIER";
        if($this->userService->ajout_utilisateur($request, $profil)){
            return $this->json("Caissier ajouté avec succès!", 201);
        }
        return $this->json("Erreur lors de l'insertion!",400); 
    }

    /**
     * @Route(
     * path="/api/admin/admin_agences",
     *  name="add_admin_agence",
     *  methods={"POST"},
     *  defaults={
     *      "_controller"="\app\ControllerApiController::ajouter_admin_agence",
     *      "_api_resource_class"=AdminAgence::class,
     *      "_api_collection_operation_name"="ajouter_admin_agence",
     *  }
     * )
     */
    public function ajouter_admin_agence( Request $request)
    {
        $profil="ADMIN_AGENCE";
        if($this->userService->ajout_utilisateur($request, $profil)){
            return $this->json("Admin agence ajouté avec succès!", 201);
        }
        return $this->json("Erreur lors de l'insertion!",400); 
    }

    /**
     * @Route(
     * path="/api/admin/user_agences",
     *  name="add_user_agence",
     *  methods={"POST"},
     *  defaults={
     *      "_controller"="\app\ControllerApiController::ajouter_user_agence",
     *      "_api_resource_class"=UserAgence::class,
     *      "_api_collection_operation_name"="ajouter_user_agence",
     *  }
     * )
     */
    public function ajouter_user_agence( Request $request)
    {
        $profil="USER_AGENCE";
        if($this->userService->ajout_utilisateur($request, $profil)){
            return $this->json("Utilisateur agence ajouté avec succès!", 201);
        }
        return $this->json("Erreur lors de l'insertion!",400); 
    }


    /**
     * @Route(
     * path="/api/admin/users/{id}",
     *  name="update_user",
     *  methods={"PUT"},
     *  defaults={
     *      "_controller"="\app\ControllerApiController::modifier_user",
     *      "_api_resource_class"=User::class,
     *      "_api_collection_operation_name"="modifier_user",
     *  }
     * )
     */
    public function modifier_user(int $id,  Request $request)
    {
        if($this->userService->modification_user($request, $id)){
            return $this->json("Utilisateur modifié avec succès!", 201);
        }
        return $this->json("Erreur lors de la modification!",400); 
     
    }
}

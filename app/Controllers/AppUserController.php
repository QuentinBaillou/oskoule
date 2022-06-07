<?php

namespace App\Controllers;

use App\Models\AppUser;
use App\Controllers\CoreController;

class AppUserController extends CoreController
{
    /**
     * Méthode permettant de lister tous les utilisateurs
     */
    public function list()
    {
        $appusersList = AppUser::findAll();

        $this->show('appuser/list', ['appusersList' => $appusersList]);
    }

    /**
     * Méthode permettant d'afficher le formulaire d'ajout ou de modification d'un utilisateur
     *
     * @param int $appuserId
     */
    public function show_form($appuserId = null)
    {
        if (is_null($appuserId)) {
            $appuser = new AppUser();
            $editMode = false;
        } else {
            $appuser = AppUser::find($appuserId);
            $editMode = true;
        }
        $_SESSION["editMode"] = $editMode;

        $this->show('appuser/form', ['appuser' => $appuser, 'editMode' => $editMode]);
    }

    /**
     * Méthode permettant d'ajouter ou de modifier les informations d'un utilisateur
     *
     * @param int $appuserId
     */
    public function create_or_update($appuserId = null)
    {
        $errorList = [];

        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);

        //vérification des données
        if (empty($email)) $errorList[] = "Il manque l'email\n";
        if (empty($name)) $errorList[] = "Il manque le nom\n";
        if (empty($password)) $errorList[] = "Il manque le mot de passe\n";
        if (empty($role)) $errorList[] = "Le role n'est pas bon\n";
        if ($status !== 1 && $status !== 2) $errorList[] = "Le status n'est pas bon\n";

        if (!is_null($email) && !is_null($name) && !is_null($password) && !is_null($role) && !is_null($status)) {
            if (is_null($appuserId)) {
                $appuser = new AppUser();
            } else {
                $appuser = AppUser::find($appuserId);
            }

            $appuser->setEmail($email);
            $appuser->setName($name);
            $appuser->setPassword(password_hash($password, PASSWORD_DEFAULT));
            $appuser->setRole($role);
            $appuser->setStatus($status);


            if (count($errorList) === 0) {
                if ($appuser->save()) {
                    header("location: http://localhost:8080/appusers");
                    exit;
                } else {
                    $errorList[] = "Erreur lors de la modification de la BDD\n";
                }
            }
        } else {
            $errorList[] = "Erreur: L'un des champs n'est pas défini\n";
        }

        if (count($errorList) > 0) {
            $editMode = $_SESSION["editMode"];
            $this->show(
                'appuser/form',
                [
                    'errorList' => $errorList,
                    'editMode' => $editMode,
                    'appuser' => $appuser
                ]
            );
        }
    }

    /**
     * Méthode permettant de supprimer un utilisateur
     *
     * @param int $appuserId
     */
    public function delete($appuserId)
    {
        $appuser = AppUser::find($appuserId);

        if($appuser->delete()) {
            header('location: http://localhost:8080/appusers');
            exit;
        } else {
            echo "Erreur lors de la suppresion de la base de données";
        }
    }
}

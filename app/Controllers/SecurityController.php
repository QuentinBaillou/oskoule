<?php

namespace App\Controllers;

use App\Controllers\CoreController;
use App\Models\AppUser;

class SecurityController extends CoreController
{
    public function showLoginForm()
    {
        $this->show('security/login');
    }

    /**
     * Méthode permettant à un utilisateur de se connecter
     */
    public function login()
    {
        $errorList = [];

        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $pwd = filter_input(INPUT_POST, 'password');

        if (!empty($email) && !empty($pwd)) {
            $user = AppUser::findByEmail($email);

            // Si on a trouvé un utilisateur avec cette adresse mail
            if ($user) {
                // Si le mot de passe saisi est le même que celui de la base de données
                if (password_verify($pwd, $user->getPassword())) {
                    $_SESSION['user'] = $user;
                    header('location: http://localhost:8080/');
                } else {
                    $errorList[] = "L'email ou le mot de passe ne correspondent pas";
                }
            } else {
                $errorList[] = "L'email ou le mot de passe ne correspondent pas";
            }
        } else {
            $errorList[] = "L'un des champs n'est pas renseigné";
        }

        if (count($errorList) > 0) {
            $this->show('security/login', ['errorList' => $errorList]);
        }
    }

    public function logout()
    {
        session_destroy();
        header('location: http://localhost:8080/');
        exit;
    }
}

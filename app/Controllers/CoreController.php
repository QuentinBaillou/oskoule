<?php

namespace App\Controllers;

class CoreController
{
    private $token = '';

    public function __construct()
    {
        $acl = [
            'main-home' => ['admin', 'user'],
            'student-add' => ['admin', 'user'],
            'student-create' => ['admin', 'user'],
            'student-edit' => ['admin', 'user'],
            'student-update' => ['admin', 'user'],
            'student-list' => ['admin', 'user'],
            'student-delete' => ['admin', 'user'],
            'teacher-list' => ['admin', 'user'],
            'teacher-add' => ['admin'],
            'teacher-create' => ['admin'],
            'teacher-edit' => ['admin'],
            'teacher-update' => ['admin'],
            'teacher-delete' => ['admin'],
            'appuser-list' => ['admin'],
            'appuser-add' => ['admin'],
            'appuser-create' => ['admin'],
            'appuser-edit' => ['admin'],
            'appuser-update' => ['admin'],
            'appuser-delete' => ['admin']
        ];

        // On récupère le nom de la route
        $route = $_SESSION["match"]['name'];

        if (array_key_exists($route, $acl)) {
            $this->checkAuthorization($acl[$route]);
        }

        $CSRFTokenPOST = [
            'student-create',
            'student-update',
            'teacher-create',
            'teacher-update',
            'appuser-create',
            'appuser-update'
        ];

        $CSRFTokenGET = [
            'student-delete',
            'teacher-delete',
            'appuser-delete'
        ];

        if (in_array($route, $CSRFTokenPOST)) {
            if (isset($_POST["csrf-token"])) {
                $token = $_POST["csrf-token"];

                if ($_SESSION["token"] === $token) {
                    unset($_SESSION["token"]);
                } else {
                    header('HTTP/1.0 403 Forbidden');
                    $this->show('error/err403');
                    exit;
                }
            } else {
                header('HTTP/1.0 403 Forbidden');
                $this->show('error/err403');
                exit;
            }
        }

        if (in_array($route, $CSRFTokenGET)) {
            if (isset($_GET["token"])) {
                $token = $_GET["token"];

                if ($_SESSION["token"] === $token) {
                    unset($_SESSION["token"]);
                } else {
                    header('HTTP/1.0 403 Forbidden');
                    $this->show('error/err403');
                    exit;
                }
            } else {
                header('HTTP/1.0 403 Forbidden');
                $this->show('error/err403');
                exit;
            }
        }

        $this->token = bin2hex(random_bytes(32));
        $_SESSION["token"] = $this->token;
    }

    public function show($viewName, $viewData = []): void
    {
        // On récupère le router depuis la session
        $viewData['router'] = $_SESSION['router'];

        extract($viewData);

        require_once __DIR__ . "/../views/layout/header.tpl.php";
        require_once __DIR__ . "/../views/{$viewName}.tpl.php";
        require_once __DIR__ . "/../views/layout/footer.tpl.php";
    }

    private function checkAuthorization($role = [])
    {
        // A-t-on un utilisateur de connecté?
        if (isset($_SESSION["user"])) {
            $user = $_SESSION["user"];
            //Si oui, a-t-il les droits requis
            if (in_array($user->getRole(), $role)) {
                return true;
            } else {
                //! Cette version marche
                header('HTTP/1.0 403 Forbidden');
                $this->show('error/err403');
                exit;
                //! Cette version ne marche pas. Elle est récursive, je ne sais pas pourquoi. C'est pourtant la même que celle vue en cours
                // $errorController = new ErrorController();
                // $errorController->err403();
                // exit;
            }
        } else {
            header("location: http://localhost:8080/login");
            exit;
        }
    }
}

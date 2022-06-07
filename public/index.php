<?php
// On inclut autoload pour gérer les dépendances et le chargement auto des classes
require_once "../vendor/autoload.php";
// On démarre une session
session_start();

// -------
// ROUTAGE
// -------

$router = new AltoRouter();

if (array_key_exists('BASE_URI', $_SERVER))
    $router->setBasePath($_SERVER['BASE_URI']);
else
    $_SERVER['BASE_URI'] = '/';

// ------
// ROUTES
// ------

$router->map(
    'GET',
    '/',
    [
        'method' => 'home',
        'controller' => '\App\Controllers\MainController'
    ],
    'main-home'
);

// --------
// TEACHERS
// --------

$router->map(
    'GET',
    '/teachers',
    [
        'method' => 'list',
        'controller' => '\App\Controllers\TeacherController'
    ],
    'teacher-list'
);
$router->map(
    'GET',
    '/teachers/add',
    [
        'method' => 'show_form',
        'controller' => '\App\Controllers\TeacherController'
    ],
    'teacher-add'
);
$router->map(
    'POST',
    '/teachers/add',
    [
        'method' => 'create_or_update',
        'controller' => '\App\Controllers\TeacherController'
    ],
    'teacher-create'
);
$router->map(
    'GET',
    '/teachers/[i:teacherId]',
    [
        'method' => 'show_form',
        'controller' => '\App\Controllers\TeacherController'
    ],
    'teacher-edit'
);
$router->map(
    'POST',
    '/teachers/[i:teacherId]',
    [
        'method' => 'create_or_update',
        'controller' => '\App\Controllers\TeacherController'
    ],
    'teacher-update'
);
$router->map(
    'GET',
    '/teachers/[i:teacherId]/delete',
    [
        'method' => 'delete',
        'controller' => '\App\Controllers\TeacherController'
    ],
    'teacher-delete'
);

// -------
// STUDENT
// -------

$router->map(
    'GET',
    '/students',
    [
        'method' => 'list',
        'controller' => '\App\Controllers\StudentController'
    ],
    'student-list'
);
$router->map(
    'GET',
    '/students/add',
    [
        'method' => 'show_form',
        'controller' => '\App\Controllers\StudentController'
    ],
    'student-add'
);
$router->map(
    'POST',
    '/students/add',
    [
        'method' => 'create_or_update',
        'controller' => '\App\Controllers\StudentController'
    ],
    'student-create'
);
$router->map(
    'GET',
    '/students/[i:studentId]',
    [
        'method' => 'show_form',
        'controller' => '\App\Controllers\StudentController'
    ],
    'student-edit'
);
$router->map(
    'POST',
    '/students/[i:studentId]',
    [
        'method' => 'create_or_update',
        'controller' => '\App\Controllers\StudentController'
    ],
    'student-update'
);
$router->map(
    'GET',
    '/students/[i:studentId]/delete',
    [
        'method' => 'delete',
        'controller' => '\App\Controllers\StudentController'
    ],
    'student-delete'
);

// -------
// APPUSER
// -------

$router->map(
    'GET',
    '/appusers',
    [
        'method' => 'list',
        'controller' => '\App\Controllers\AppUserController'
    ],
    'appuser-list'
);
$router->map(
    'GET',
    '/appusers/add',
    [
        'method' => 'show_form',
        'controller' => '\App\Controllers\AppUserController'
    ],
    'appuser-add'
);
$router->map(
    'POST',
    '/appusers/add',
    [
        'method' => 'create_or_update',
        'controller' => '\App\Controllers\AppUserController'
    ],
    'appuser-create'
);
$router->map(
    'GET',
    '/appusers/[i:appuserId]',
    [
        'method' => 'show_form',
        'controller' => '\App\Controllers\AppUserController'
    ],
    'appuser-edit'
);
$router->map(
    'POST',
    '/appusers/[i:appuserId]',
    [
        'method' => 'create_or_update',
        'controller' => '\App\Controllers\AppUserController'
    ],
    'appuser-update'
);
$router->map(
    'GET',
    '/appusers/[i:appuserId]/delete',
    [
        'method' => 'delete',
        'controller' => '\App\Controllers\AppUserController'
    ],
    'appuser-delete'
);

// --------
// SECURITY
// --------

$router->map(
    'GET',
    '/login',
    [
        'method' => 'showLoginForm',
        'controller' => '\App\Controllers\SecurityController' // On indique le FQCN de la classe
    ],
    'security-login-form'
);
$router->map(
    'POST',
    '/login',
    [
        'method' => 'login',
        'controller' => '\App\Controllers\SecurityController' // On indique le FQCN de la classe
    ],
    'security-login'
);
$router->map(
    'GET',
    '/logout',
    [
        'method' => 'logout',
        'controller' => '\App\Controllers\SecurityController' // On indique le FQCN de la classe
    ],
    'security-logout'
);

// On envoie le router dans la session pour y avoir accès sur les autres pages et fichiers
$_SESSION['router'] = $router;

// Récupération des paramètres des routes et envoie dans la session
$match = $router->match();
$_SESSION['match'] = $match;

// ----------
// Dispatcher
// ----------

$dispatcher = new Dispatcher($match, '\App\Controllers\ErrorController#err404');
$dispatcher->dispatch();

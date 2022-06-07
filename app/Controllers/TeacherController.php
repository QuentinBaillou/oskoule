<?php

namespace App\Controllers;

use App\Models\Teacher;
use App\Controllers\CoreController;

class TeacherController extends CoreController
{
    /**
     * Méthode permettant de lister tous les professeurs
     */
    public function list()
    {
        $teachersList = Teacher::findAll();

        $this->show('teacher/list', ['teachersList' => $teachersList]);
    }

    /**
     * Méthode permettant d'afficher le formulaire d'ajout ou de modification d'un professeur
     *
     * @param int $teacherId
     */
    public function show_form($teacherId = null)
    {
        if (is_null($teacherId)) {
            $teacher = new Teacher();
            $editMode = false;
        } else {
            $teacher = Teacher::find($teacherId);
            $editMode = true;
        }
        $_SESSION["editMode"] = $editMode;
        $this->show('teacher/form', ['teacher' => $teacher, 'editMode' => $editMode]);
    }

    /**
     * Méthode permettant d'ajouter ou de modifier les informations d'un professeur
     *
     * @param int $teacherId
     */
    public function create_or_update($teacherId = null)
    {
        $errorList = [];

        $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $job = filter_input(INPUT_POST, 'job', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);

        // Vérification des données
        if (empty($firstname)) $errorList[] = "Il manque le prénom\n";
        if (empty($lastname)) $errorList[] = "Il manque le nom\n";
        if (empty($job)) $errorList[] = "Il manque le rôle\n";
        if ($status !== 1 && $status !== 2) $errorList[] = "Le status n'est pas bon\n";

        if (!is_null($firstname) && !is_null($lastname) && !is_null($job) && !is_null($status)) {
            if (is_null($teacherId)) {
                $teacher = new Teacher();
            } else {
                $teacher = Teacher::find($teacherId);
            }

            $teacher->setFirstname($firstname);
            $teacher->setLastname($lastname);
            $teacher->setJob($job);
            $teacher->setStatus($status);

            if (count($errorList) === 0) {
                if ($teacher->save()) {
                    header("location: http://localhost:8080/teachers");
                    exit;
                } else {
                    $errorList[] = "Erreur lors de la modification de la BDD";
                }
            }
        } else {
            $errorList[] = "Erreur: L'un des champs n'est pas défini";
        }

        if (count($errorList) > 0) {
            $editMode = $_SESSION["editMode"];
            $this->show(
                'teacher/form',
                [
                    'errorList' => $errorList,
                    'editMode' => $editMode,
                    'teacher' => $teacher
                ]
            );
        }
    }

    /**
     * Méthode permettant de supprimer un professeur
     *
     * @param int $teacherId
     */
    public function delete($teacherId)
    {
        $teacher = Teacher::find($teacherId);

        if($teacher->delete()) {
            header('location: http://localhost:8080/teachers');
            exit;
        } else {
            echo "Erreur lors de la suppresion de la base de données";
        }
    }
}

<?php

namespace App\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Controllers\CoreController;

class StudentController extends CoreController
{
    /**
     * Méthode permettant de lister tous les étudiants
     */
    public function list()
    {
        $studentsList = Student::findAll();

        $this->show('student/list', ['studentsList' => $studentsList]);
    }

    /**
     * Méthode permettant d'afficher le formulaire d'ajout ou de modification d'un étudiant
     *
     * @param int $studentId
     */
    public function show_form($studentId = null)
    {
        if (is_null($studentId)) {
            $student = new Student();
            $editMode = false;
        } else {
            $student = Student::find($studentId);
            $editMode = true;
        }

        $teachersList = Teacher::findAll();
        $_SESSION["editMode"] = $editMode;

        $this->show('student/form', ['student' => $student, 'editMode' => $editMode, 'teachersList' => $teachersList]);
    }

    /**
     * Méthode permettant d'ajouter ou de modifier les informations d'un étudiant
     *
     * @param int $studentId
     */
    public function create_or_update($studentId = null)
    {
        $errorList = [];

        $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $teacherId = filter_input(INPUT_POST, 'teacher', FILTER_VALIDATE_INT);
        $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);

        var_dump($teacherId);
        //vérification des données
        if (empty($firstname)) $errorList[] = "Il manque le prénom\n";
        if (empty($lastname)) $errorList[] = "Il manque le nom\n";
        if (empty($teacherId)) $errorList[] = "Il manque le professeur\n";
        if ($status !== 1 && $status !== 2) $errorList[] = "Le status n'est pas bon\n";

        if (!is_null($firstname) && !is_null($lastname) && !is_null($teacherId) && !is_null($status)) {
            if (is_null($studentId)) {
                $student = new Student();
            } else {
                $student = Student::find($studentId);
            }

            $student->setFirstname($firstname);
            $student->setLastname($lastname);
            $student->setTeacherId($teacherId);
            $student->setStatus($status);

            if (count($errorList) === 0) {
                if ($student->save()) {
                    header("location: http://localhost:8080/students");
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
                'student/form',
                [
                    'errorList' => $errorList,
                    'editMode' => $editMode,
                    'student' => $student
                ]
            );
        }
    }

    /**
     * Méthode permettant de supprimer un étudiant
     *
     * @param int $studentId
     */
    public function delete($studentId)
    {
        $student = Student::find($studentId);

        if($student->delete()) {
            header('location: http://localhost:8080/students');
            exit;
        } else {
            echo "Erreur lors de la suppresion de la base de données";
        }
    }
}

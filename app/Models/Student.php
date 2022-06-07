<?php

namespace App\Models;

use PDO;
use App\Utils\Database;

class Student extends CoreModel
{
    private $firstname;
    private $lastname;
    private $teacher_id;

    /**
     * Trouve toute les entrées de la table student
     *
     * @return Student[]
     */
    public static function findAll()
    {
        // Laison base de donnée
        $pdo = Database::getPDO();

        // Préparation de la requête SQL
        $sql = "SELECT * FROM `student`";

        // Execution de la requête SQL
        $pdoStatement = $pdo->query($sql);

        // On retourne les données récupérées depuis la BDD
        return $pdoStatement->fetchAll(PDO::FETCH_CLASS, __CLASS__);
    }

    /**
     * Trouve une entrée de la table student
     *
     * @param int $studentId
     * @return Student
     */
    public static function find($studentId)
    {
        $pdo = Database::getPDO();

        $stmt = $pdo->prepare("SELECT * FROM `student` WHERE `id` = :id");

        $stmt->bindParam('id', $studentId);

        if($stmt->execute()) {
            return $stmt->fetchObject(__CLASS__);
        }
        return false;
    }

    /**
     * Insère une nouvelle entrée dans la table student
     *
     * @return bool
     */
    public function create()
    {
        $pdo = Database::getPDO();

        $stmt = $pdo->prepare(
            "INSERT INTO `student` (`firstname`, `lastname`, `status`, `teacher_id`)
            VALUES (:firstname, :lastname, :status, :teacher_id)
            ");

        $stmt->bindParam('firstname', $this->firstname);
        $stmt->bindParam('lastname', $this->lastname);
        $stmt->bindParam('teacher_id', $this->teacher_id);
        $stmt->bindParam('status', $this->status);

        if($stmt->execute()) {
            $this->id = $pdo->lastInsertId();
            return true;
        }
        return false;
    }

    /**
     * Modifie une entrée déja existante dans la table student
     *
     * @return bool
     */
    public function update()
    {
        $pdo = Database::getPDO();

        $stmt = $pdo->prepare(
            "UPDATE `student`
            SET
                `firstname` = :firstname,
                `lastname` = :lastname,
                `status` = :status,
                `teacher_id` = :teacher_id,
                `updated_at` = NOW()
            WHERE `id` = :id
            ");

        $stmt->bindParam('id', $this->id);
        $stmt->bindParam('firstname', $this->firstname);
        $stmt->bindParam('lastname', $this->lastname);
        $stmt->bindParam('teacher_id', $this->teacher_id);
        $stmt->bindParam('status', $this->status);

        return $stmt->execute();
    }

    /**
     * Supprime un étudiant
     */
    public function delete()
    {
        $pdo = Database::getPDO();

        $stmt = $pdo->prepare("DELETE FROM `student` WHERE `id` = :id");

        $stmt->bindParam('id', $this->id);

        return $stmt->execute();
    }
    
    /**
     * Get the value of firstname
     */ 
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     */ 
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * Get the value of lastname
     */ 
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     */ 
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * Get the value of teacher_id
     */ 
    public function getTeacherId()
    {
        return $this->teacher_id;
    }

    /**
     * Set the value of teacher_id
     */ 
    public function setTeacherId($teacherId)
    {
        $this->teacher_id = $teacherId;
    }
}

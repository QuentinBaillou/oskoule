<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class Teacher extends CoreModel
{
    private $firstname;
    private $lastname;
    private $job;

    /**
     * Trouve toute les entrées de la table teacher
     *
     * @return Teacher[]
     */
    public static function findAll()
    {
        // Laison base de donnée
        $pdo = Database::getPDO();

        // Préparation de la requête SQL
        $sql = "SELECT * FROM `teacher`";

        // Execution de la requête SQL
        $pdoStatement = $pdo->query($sql);

        // On retourne les données récupérées dans la BDD
        return $pdoStatement->fetchAll(PDO::FETCH_CLASS, __CLASS__);
    }

    /**
     * Trouve une entrée de la table teacher
     *
     * @param int $teacherId
     * @return Teacher
     */
    public static function find($teacherId)
    {
        $pdo = Database::getPDO();

        $stmt = $pdo->prepare("SELECT * FROM `teacher` WHERE `id` = :id");

        $stmt->bindParam('id', $teacherId);

        if ($stmt->execute()) {
            return $stmt->fetchObject(__CLASS__);
        }
        return false;
    }

    /**
     * Insère une nouvelle entrée dans la table teacher
     *
     * @return bool
     */
    public function create()
    {
        $pdo = Database::getPDO();

        $stmt = $pdo->prepare(
            "INSERT INTO `teacher` (`id`, `firstname`, `lastname`, `job`, `status`)
            VALUES (:id, :firstname, :lastname, :job, :status)
            "
        );

        $stmt->bindParam('id', $this->id);
        $stmt->bindParam('firstname', $this->firstname);
        $stmt->bindParam('lastname', $this->lastname);
        $stmt->bindParam('job', $this->job);
        $stmt->bindParam('status', $this->status);

        if ($stmt->execute()) {
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
            "UPDATE `teacher`
            SET
                `firstname` = :firstname,
                `lastname` = :lastname,
                `status` = :status,
                `job` = :job,
                `updated_at` = NOW()
            WHERE `id` = :id
            "
        );

        $stmt->bindParam('id', $this->id);
        $stmt->bindParam('firstname', $this->firstname);
        $stmt->bindParam('lastname', $this->lastname);
        $stmt->bindParam('job', $this->job);
        $stmt->bindParam('status', $this->status);

        return $stmt->execute();
    }

    /**
     * Supprime un professeur
     */
    public function delete()
    {
        $pdo = Database::getPDO();

        $stmt = $pdo->prepare("DELETE FROM `teacher` WHERE `id` = :id");

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
     * Get the value of job
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Set the value of job
     */
    public function setJob($job)
    {
        $this->job = $job;
    }
}

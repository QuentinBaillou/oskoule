<?php

namespace App\Models;

use PDO;
use App\Utils\Database;

class AppUser extends CoreModel
{
    private $email;
    private $name;
    private $password;
    private $role;

    /**
     * Trouve une entrée de la table app_user en fonction de son email
     *
     * @param int $appuserId
     * @return AppUser
     */
    public static function findByEmail($app_userId)
    {
        $pdo = Database::getPDO();

        $stmt = $pdo->prepare("SELECT * FROM `app_user` WHERE `email` = :email");

        $stmt->bindParam('email', $app_userId);

        if ($stmt->execute()) {
            return $stmt->fetchObject(__CLASS__);
        }
        return false;
    }

    /**
     * Trouve toute les entrées de la table appuser
     *
     * @return AppUser[]
     */
    public static function findAll()
    {
        // Laison base de donnée
        $pdo = Database::getPDO();

        // Préparation de la requête SQL
        $sql = "SELECT * FROM `app_user`";

        // Execution de la requête SQL
        $pdoStatement = $pdo->query($sql);

        // On retourne les données récupérées depuis la BDD
        return $pdoStatement->fetchAll(PDO::FETCH_CLASS, __CLASS__);
    }

    /**
     * Trouve une entrée de la table appuser
     *
     * @param int $appuserId
     * @return AppUser
     */
    public static function find($appuserId)
    {
        $pdo = Database::getPDO();

        $stmt = $pdo->prepare("SELECT * FROM `app_user` WHERE `id` = :id");

        $stmt->bindParam('id', $appuserId);

        if ($stmt->execute()) {
            return $stmt->fetchObject(__CLASS__);
        }
        return false;
    }

    /**
     * Insère une nouvelle entrée dans la table appuser
     *
     * @return bool
     */
    public function create()
    {
        $pdo = Database::getPDO();

        $stmt = $pdo->prepare(
            "INSERT INTO `app_user` (`email`, `name`, `password`, `role`, `status`)
            VALUES (:email, :name, :password, :role, :status)
            "
        );

        $stmt->bindParam('email', $this->email);
        $stmt->bindParam('name', $this->name);
        $stmt->bindParam('role', $this->role);
        $stmt->bindParam('password', $this->password);
        $stmt->bindParam('status', $this->status);

        if ($stmt->execute()) {
            $this->id = $pdo->lastInsertId();
            return true;
        }
        return false;
    }

    /**
     * Modifie une entrée déja existante dans la table appuser
     *
     * @return bool
     */
    public function update()
    {
        $pdo = Database::getPDO();

        $stmt = $pdo->prepare(
            "UPDATE `app_user`
            SET
                `email` = :email,
                `name` = :name,
                `password` = :password,
                `role` = :role,
                `status` = :status,
                `updated_at` = NOW()
            WHERE `id` = :id
            "
        );

        $stmt->bindParam('id', $this->id);
        $stmt->bindParam('email', $this->email);
        $stmt->bindParam('name', $this->name);
        $stmt->bindParam('status', $this->status);
        $stmt->bindParam('role', $this->role);
        $stmt->bindParam('password', $this->password);

        return $stmt->execute();
    }

    /**
     * Supprime un utilisateur
     */
    public function delete()
    {
        $pdo = Database::getPDO();

        $stmt = $pdo->prepare("DELETE FROM `app_user` WHERE `id` = :id");

        $stmt->bindParam('id', $this->id);

        return $stmt->execute();
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get the value of role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }
}

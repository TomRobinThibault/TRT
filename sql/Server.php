<?php
class Server
{
    private $host = "127.0.0.1";
    private $database = "ecole_trt";
    private $user = "root";
    private $password = "";

    private $connection;


    function __construct() {
        $this->connection = new PDO("mysql:host=$this->host;dbname=$this->database;charset=utf8", $this->user, $this->password);
    }

    function __destruct() {
        $this->connection = null;
    }

    /*
     *
     *
     * Fonction pour gérer les utilisateurs
     *
     *
     */
    function createUser($pseudo, $hash) {
        $stmt = $this->connection->prepare("INSERT INTO utilisateur(pseudoUser, hashUser, dateCreation, dateLastUtilisation) VALUES (:pseudo,:hash,:curDate,:lastDate);");

        $dateCreation = date("d/m/y H:i:s");

        $stmt->bindParam("pseudo", $pseudo, PDO::PARAM_STR);
        $stmt->bindParam("hash", $hash, PDO::PARAM_STR);
        $stmt->bindParam("curDate", $dateCreation, PDO::PARAM_STR);
        $stmt->bindParam("lastDate", $dateCreation, PDO::PARAM_STR);
        return $stmt->execute();
    }
    function updateUserUse($pseudo) {
        $stmt = $this->connection->prepare("UPDATE utilisateur SET dateLastUtilisation = :lastDate WHERE pseudoUser = :pseudo;");

        $date = date("d/m/y H:i:s");

        $stmt->bindParam("pseudo", $pseudo, PDO::PARAM_STR);
        $stmt->bindParam("lastDate", $date, PDO::PARAM_STR);
        return $stmt->execute();
    }
    function getUserByPseudo($pseudo) {
        $stmt = $this->connection->prepare("SELECT * FROM utilisateur WHERE pseudoUser=:pseudo;");
        $stmt->bindParam("pseudo", $pseudo, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ)[0];
    }
    function testPasswordUser($pseudo, $hash) {
        $stmt = $this->connection->prepare("SELECT hashUser FROM utilisateur WHERE pseudoUser = :pseudo;");
        $stmt->bindParam("pseudo", $pseudo, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ)[0]->hashUser == $hash;
    }
}
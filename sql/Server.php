<?php
class Server
{
    private $host = "127.0.0.1";
    private $database = "quiquiz";
    private $user = "ecole_quiquiz";
    private $password = "dh9fbH4ujccXfV4Q";

    private $connection;


    function __construct() {
        $this->connection = new PDO("mysql:host=$this->host;dbname=$this->database;charset=utf8", $this->user, $this->password);
    }

    function __destruct() {
        $this->connection = null;
    }
    function updateUser($idJoueur, $champ, $valeur) {
        $stmt = $this->connection->prepare("UPDATE joueur SET :champ=:valeur WHERE idJoueur=:idJoueur;");
        $stmt->bindParam("idJoueur", $idJoueur, PDO::PARAM_INT);
        $stmt->bindParam("champ", $champ, PDO::PARAM_STR);
        $stmt->bindParam("valeur", $valeur, PDO::PARAM_STR);
        return $stmt->execute();
    }
    function createScore($idJoueur, $idQuiz, $score) {
        $stmt = $this->connection->prepare("INSERT INTO avoir(idJoueur, idQuiz, score) VALUES (:idJoueur,:idQuiz,:score);");
        $stmt->bindParam("idJoueur", $idJoueur, PDO::PARAM_INT);
        $stmt->bindParam("idQuiz", $idQuiz, PDO::PARAM_INT);
        $stmt->bindParam("score", $score, PDO::PARAM_INT);
        return $stmt->execute();
    }
    function asScore($idJoueur, $idQuiz)
    {
        $stmt = $this->connection->prepare("SELECT score FROM avoir WHERE idJoueur=:idJoueur AND idQuiz=:idQuiz;");
        $stmt->bindParam("idJoueur", $idJoueur, PDO::PARAM_INT);
        $stmt->bindParam("idQuiz", $idQuiz, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() >= 1;
    }
    function getJoueurIdFromMail($mail) {
        $stmt = $this->connection->prepare("SELECT idJoueur FROM joueur WHERE mailJoueur=:mail;");
        $stmt->bindParam("mail", $mail, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    function asGoodPassword($idJoueur, $hash) {
        $stmt = $this->connection->prepare("SELECT hashJoueur FROM joueur WHERE idJoueur=:idJoueur;");
        $stmt->bindParam("idJoueur", $idJoueur, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ)[0]->hashJoueur == $hash;
    }
}
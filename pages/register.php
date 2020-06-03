<?php
include "../tools/server.php";

if (isset($_POST["req_register"])) {

    $user = $pwd = $pwdRepeat = $email = $pseudo = "";

    $user = filter_input(INPUT_POST, "user", FILTER_SANITIZE_STRING);
    $pseudo = filter_input(INPUT_POST, "pseudo", FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $pwd = filter_input(INPUT_POST, "pwd", FILTER_SANITIZE_STRING);
    $pwdRepeat = filter_input(INPUT_POST, "pwdRepeat", FILTER_SANITIZE_STRING);

    $user = mysqli_real_escape_string($mysql, $user);
    $pseudo = mysqli_real_escape_string($mysql, $pseudo);
    $email = mysqli_real_escape_string($mysql, $email);
    $pwd = mysqli_real_escape_string($mysql, $pwd);
    $pwdRepeat = mysqli_real_escape_string($mysql, $pwdRepeat);

    if (!empty($user) && !empty($pseudo) && !empty($email) && !empty($pwd) && !empty($pwdRepeat)) {

        if ($pwd != $pwdRepeat) {
            $errors = "Les deux mots de passes ne sont pas pareil !";
        } else {
            if (isMysqlUserExist($mysql, $user)) {
                $errors = "Utilisateur deja utilisé !";
            } else {
                $result = MysqlRegisterNewUser($mysql, $pseudo, $user, $email, $pwd);

                if (!$result) {
                    $errors = "Une erreur est survenu, veuillez essayer plus tard !";
                    echo mysqli_error($mysql);
                } else {
                    $user = "";
                    $validate = "Vous etes bien enregistrer, vous pouvez vous loger !";
                }
            }
        }
    } else {
        $errors = "Verifiez vos donnée !";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>S'enregistrer</title>
        <link href="../css/admin/register.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <fieldset>
            <div class="titre">
                <h2>S'enregistrer</h2>
            </div>
            <?php if (isset($errors)) {
                echo '<p class="errors">' . $errors . "</p>";
            } else if (isset($validate)) {
                echo '<p class="valid">' . $validate . '</p>';
            } ?>
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                <label for="user">Identifiant de connection :</label><br/>
                <p>
                    <input type="text" name="user" value="<?php if (isset($errors)) {
                echo $user;
            } ?>" placeholder="Username" required="" />
                </p>
                <label for="user">Pseudo :</label><br/>
                <p>
                    <input type="text" name="pseudo" value="<?php if (isset($errors)) {
                echo $pseudo;
            } ?>" placeholder="Username" required="" />
                </p>
                <label for="user">Email :</label><br/>
                <p>
                    <input type="email" name="email" value="<?php if (isset($errors)) {
                echo $email;
            } ?>" placeholder="Username" required="" />
                </p>
                <label for="pwd">Mot de passe :</label><br/>
                <p>
                    <input type="password" name="pwd" placeholder="Password" required="" />
                </p>
                <label for="pwd">Répetez le mot de passe :</label><br/>
                <p>
                    <input type="password" name="pwdRepeat" placeholder="Repeat Password" required="" />
                </p>
                <p>
                    <input type="submit" name="req_register" value="S'enregistrer" />
                </p>
            </form>
            <a href="../">Retour a l'accueil</a>
        </fieldset>
    </body>
</html>

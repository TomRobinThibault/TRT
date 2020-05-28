<?php
    include "../tools/server.php";

    if (isset($_SESSION['logged_user'])){
        $user = $_SESSION['logged_user'];
    }
    if (isset($_GET['delogger'])){
        Mysqldelog($mysql, $user, true, "../accueil.php");
    }

    if (isset($_POST["req_login"])){
        
        $user = $pwd = "";
        
        $user = filter_input(INPUT_POST, "user", FILTER_SANITIZE_STRING);
        $pwd = filter_input(INPUT_POST, "pwd", FILTER_SANITIZE_STRING);
        
        $user = mysqli_real_escape_string($mysql, $user);
        $pwd = mysqli_real_escape_string($mysql, $pwd);
        
        if (isMysqlEmailExist($mysql, $user)){
            $user = getMysqlUserByEmail($mysql, $user);
        }
        
        if (isMysqlUserExist($mysql, $user)){
            if (isMysqlUserPassword($mysql, $user, $pwd)){
                
                $validate = "Connection reussi !";
                
                MysqlLoginUser($mysql, $user, true, "Admin/dashboard.php");
            } else {
                $errors = "Utilisateur ou mot de passe incorrecte ! ";
            }
        } else {
            $errors = "Utilisateur ou mot de passe incorrecte ! ";
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Se loger</title>
        <link href="../css/admin/login.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <fieldset>
            <div class="titre">
                <h2>Se loger</h2>
            </div>
            <?php if (isset($errors)) {echo '<p class="errors">'.$errors."</p>";} else if (isset($validate)) {echo '<p class="valid">'.$validate.'</p>';}?>
            <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
                <label for="user">Identifiant ou email :</label><br/>
                <p>
                    <input type="text" name="user" value="<?php if (isset($errors)) {echo $user;}?>" placeholder="Username" required="" />
                </p>
                <label for="pwd">Mot de passe :</label><br/>
                <p>
                    <input type="password" name="pwd" placeholder="Password" required="" />
                </p>
                <p>
                    <input type="submit" name="req_login" value="Login" />
                </p>
            </form>
            <a href="index.php">Retour a l'accueil</a>
        </fieldset>
    </body>
</html>

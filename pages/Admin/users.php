<?php
$ROOT = "../../";
include $ROOT . 'tools/server.php';
$user = "";
if (isset($_SESSION["logged_user"])) {
    $user = $_SESSION["logged_user"];
    kickNoAccessPageArray($mysql, $user, array("admin.panel.manage.users", "admin.panel.add.users"));
} else {
    header("Location: ../index.php");
}
if (isset($_SESSION["valid"])){
    $sended = filter_var($_SESSION["valid"], FILTER_SANITIZE_STRING);
    $validateModifa = str_replace("%dg", " de ", $sended);
    $validateModifd = str_replace("%", " ", $validateModifa);
    $validateModifc = str_replace("/b/", "<b>", $validateModifd);
    $validateModife = str_replace("/bf/", "</b>", $validateModifc);
    $validateModif = str_replace("/br/", "<br/>", $validateModife);
    
    unset($_SESSION["valid"]);
}
if (isset($_POST["req_register"])){
    $pseudo = filter_input(INPUT_POST, "pseudo", FILTER_SANITIZE_STRING);
    $identifiant = filter_input(INPUT_POST, "identifiant", FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $pwd = filter_input(INPUT_POST, "pwd", FILTER_SANITIZE_STRING);
    $pwdRepeat = filter_input(INPUT_POST, "pwdRepeat", FILTER_SANITIZE_STRING);
    
    $identifiant = mysqli_real_escape_string($mysql, $identifiant);
    $pseudo = mysqli_real_escape_string($mysql, $pseudo);
    $email = mysqli_real_escape_string($mysql, $email);
    $pwd = mysqli_real_escape_string($mysql, $pwd);
    $pwdRepeat = mysqli_real_escape_string($mysql, $pwdRepeat);
    
    if (!empty($identifiant) && !empty($pseudo) && !empty($email) && !empty($pwd) && !empty($pwdRepeat)) {

        if ($pwd != $pwdRepeat) {
            $errors = "Les deux mots de passes ne sont pas pareil !";
        } else {
            if (isMysqlUserExist($mysql, $identifiant)) {
                $errors = "Utilisateur deja utilisé !";
            } else {
                $result = MysqlRegisterNewUser($mysql, $pseudo, $identifiant, $email, $pwd);

                if (!$result) {
                    $errors = "Une erreur est survenu, veuillez essayer plus tard !";
                    echo mysqli_error($mysql);
                } else {
                    $validate = $identifiant." est maintenant enregistrer !";
                    $identifiant = "";
                }
            }
        }
    } else {
        $errors = "Verifiez vos donnée !";
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Administration - Users</title>
        <link href="<?=$ROOT?>css/admin/users.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php include 'header-panel.php'; ?>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <h2>Gestion des Utilisateurs</h2>
            <div class="manageUser">
                <?php
                if (!empty($validateModif)){echo "<div class=\"alert alert-success\" role=\"alert\">$validateModif</div>";}
                if (asPermissionArray($mysql, $user, array("admin.panel.manage.users", "admin.panel.modif.users", "admin.panel.modif.users.permissions", "admin.panel.modif.users.password"))){
                    echo '<table class="table table-striped">
                        <thead>
                          <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Pseudo</th>
                            <th scope="col">Identifiant</th>
                            <th scope="col">Email</th>
                            <th scope="col">Date de Création</th>
                            <th scope="col">Dernière utilisation</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>';
                    foreach (getMysqlUsers($mysql) as $row){
                        echo '<tr>
                                <th scope="row">'.$row["idUser"].'</th>
                                <td>'.$row["pseudoUser"].'</td>
                                <td>'.$row["identifiantUser"].'</td>
                                <td>'.$row["emailUser"].'</td>
                                <td>'.$row["dateCreation"].'</td>
                                <td>'.$row["dateLastUtilisation"].'</td>
                                <td><a class="btn btn-outline-secondary" href="modifUser.php?id='.$row["idUser"].'">Modifier</a></td>
                              </tr>';
                    }
                    echo '</tbody>
                    </table>';
                } else {
                    echo "<div class=\"alert alert-primary\" role=\"alert\">Vous n'avez pas la permission !</div>";
                }
                ?>
                <h3>Enregistrement</h3>
                <?php
                if (asPermission($mysql, $user, "admin.panel.add.users")){
                    if (isset($errors)){
                        echo "<div style=\"background-color:red;\">$errors</div><br>";
                    }
                    if (isset($validate)){
                         echo "<div style=\"background-color:green;\">$validate</div><br>";
                    }
                    
                    echo '<form action="users.php" method="POST">
                    <div class="form-row">
                      <div class="col-md-4 mb-3">
                        <label>Pseudo</label>
                        <input type="text" class="form-control" name="pseudo" placeholder="pseudo de l\'utilisateur" required>
                      </div>
                      <div class="col-md-4 mb-3">
                        <label>Identifiant de connection</label>
                        <input type="text" class="form-control" name="identifiant" placeholder="identifiant de l\'utilisateur" required>
                      </div>
                    <div class="col-md-6 mb-3">
                        <label>E-Mail</label>
                        <input type="text" class="form-control" name="email" placeholder="example@canardconfit.ch" required>
                    </div>
                    </div>
                    <div class="form-row">
                      <div class="col-md-6 mb-3">
                        <label>Mot de Passe</label>
                        <input type="password" class="form-control" name="pwd" required>
                      </div>
                      <div class="col-md-6 mb-3">
                        <label>Répetez le Mot de Passe</label>
                        <input type="password" class="form-control" name="pwdRepeat" required>
                      </div>
                    </div>
                    <button class="btn btn-primary btn-lg" name="req_register" type="submit">Enregistrer</button>
                </form>';
                } else {
                    echo "<div class=\"alert alert-primary\" role=\"alert\">Vous n'avez pas la permission !</div>";
                }
                ?>
            </div>
        </main>
    </body>
</html>
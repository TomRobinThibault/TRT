<?php
$ROOT = "../../";
include $ROOT . 'tools/server.php';

$errorsInfo = "";
$validateInfo = $validatePerm = $validateGroup = "";

$userAdm = "";
if (isset($_SESSION["logged_user"])) {
    $userAdm = $_SESSION["logged_user"];
    $idAdm = getMysqlIdUserByUser($mysql, $userAdm);
    kickNoAccessPageArray($mysql, $userAdm, array("admin.panel.modif.users", "admin.panel.modif.users.groups", "admin.panel.modif.users.permissions", "admin.panel.modif.users.password"));
} else {
    header("Location: users.php");
}
if (isset($_GET["id"])) {
    $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
    $user = getMysqlUserById($mysql, $id);
} else if (!isset($_POST["req_modif"]) || !isset($_GET["change"])) {
    header("Location: users.php");
}
if (isset($_POST["req_modif"]) && isset($_GET["change"])) {
    $req_modif = filter_input(INPUT_POST, "req_modif", FILTER_SANITIZE_STRING);
    $id = filter_input(INPUT_GET, "change", FILTER_SANITIZE_NUMBER_INT);
    
    if ($req_modif == "annul") {

        header("Location: users.php");
    } else if ($req_modif == "rec") {
        $pseudo = $identifiant = $email = $pwd = $pwdRepeat = "";
        if (asPermission($mysql, getMysqlUserById($mysql, $idAdm)["identifiantUser"], "admin.panel.modif.users")){
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

            if (isMysqlModifChamp($mysql, $id, "pseudoUser", $pseudo)) {
                $validateInfo .= "/b/$identifiant/bf/ : Pseudo changé ! /br/";
                updateMysqlUserChamp($mysql, $id, "pseudoUser", $pseudo);
            }
            if (isMysqlModifChamp($mysql, $id, "identifiantUser", $identifiant)) {
                $validateInfo .= "/b/$identifiant/bf/ : Identifiant changé ! /br/";
                updateMysqlUserChamp($mysql, $id, "identifiantUser", $identifiant);
            }
            if (isMysqlModifChamp($mysql, $id, "emailUser", $email)) {
                $validateInfo .= "/b/$identifiant/bf/ : Email changé ! /br/";
                updateMysqlUserChamp($mysql, $id, "emailUser", $email);
            }
        }
        
        if (asPermission($mysql, getMysqlUserById($mysql, $idAdm)["identifiantUser"], "admin.panel.modif.users.password")){
            if ($pwd != null && $pwd == $pwdRepeat) {
                $validateInfo .= "/b/$identifiant/bf/ : Mot de passe changé ! /br/";
                updateMysqlUserChamp($mysql, $id, "hashUser", md5($pwd));
            } else if ($pwd != $pwdRepeat) {
                $errorsInfo .= "/b/$identifiant/bf/ : Les deux mots de passe ne sont pas les mêmes !";
            }
        }
        
        if (asPermission($mysql, getMysqlUserById($mysql, $idAdm)["identifiantUser"], "admin.panel.modif.users.permissions")){
            foreach (getMysqlPermsID($mysql) as $permID) {
                $vl = filter_input(INPUT_POST, "UserPerm-$permID", FILTER_SANITIZE_STRING);
                $code = getMysqlPermissionByID($mysql, $permID)["codePermission"];
                $bool;

                if ($vl == "on"){
                    $bool = true;
                } else {
                    $bool = false;
                }

                if (asPermission($mysql, $identifiant, $code) != $bool){
                    $validatePerm .= "/b/$identifiant/bf/ : Code ".$code." changé ! /br/";
                }
                MysqlChangePerm($mysql, $identifiant, $code, $bool);
            }
        }
        
        if (asPermission($mysql, getMysqlUserById($mysql, $idAdm)["identifiantUser"], "admin.panel.modif.users.groups")){
            foreach (getMysqlGroupsID($mysql) as $groupID) {
                $vl = filter_input(INPUT_POST, "UserGroup-$groupID", FILTER_SANITIZE_STRING);
                $group = getMysqlGroupByID($mysql, $groupID);
                $nom = $group["nomGroupe"];
                $bool;

                if ($vl == "on" || $group["defaut"] == 1){
                    $bool = true;
                } else {
                    $bool = false;
                }

                if (isInGroup($mysql, $identifiant, $nom) != $bool){
                    $validateGroup .= "/b/$identifiant/bf/ : Appartenance du groupe ".$nom." changé ! /br/";
                }
                MysqlChangeAppartenanceGroupe($mysql, $identifiant, $nom, $bool);
            }
        }

        $user = getMysqlUserById($mysql, $id);
        
        if (empty($errorsInfo) &&
           (!empty($validateInfo) ||
            !empty($validatePerm) ||
            !empty($validateGroup))){
            $validateModifa = str_replace(" de ", "%dg", $validateInfo.$validatePerm.$validateGroup);
            $validateModif = str_replace(" ", "%", $validateModifa);
            $_SESSION["valid"] = $validateModif;
            
            header("Location: users.php");
        }
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Administration - Users</title>
        <link href="<?= $ROOT ?>css/admin/users.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php include 'header-panel.php'; ?>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4"> 
            <h2>Modification d'un utilisateur</h2>
            <br>
            <form action="modifUser.php?change=<?php echo $id; ?>" method="POST">
                <h4>Information sur l'utilisateur</h4>
                <?php
                if (asPermissionArray($mysql, $userAdm, array("admin.panel.modif.users.password"), "admin.panel.modif.users")) {
                    if (!empty($validateInfo)) {
                        echo "<div class=\"alert alert-success\" role=\"alert\">" . str_replace("/b/", "<b>", str_replace("/bf/", "</b>", str_replace("/br/", "<br/>", $validateInfo))) . "</div>";
                    }
                    if (!empty($errorsInfo)) {
                        echo "<div class=\"alert alevrt-danger\" role=\"alert\">" . str_replace("/b/", "<b>", str_replace("/bf/", "</b>", str_replace("/br/", "<br/>", $errorsInfo))) . "</div>";
                    }
                } else {
                    echo "<div class=\"alert alert-primary\" role=\"alert\">Vous n'avez pas la permission !</div>";
                }
                
                if (asPermission($mysql, $userAdm, "admin.panel.modif.users")) {
                    
                    echo '<div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label>Pseudo</label>
                            <input type="text" class="form-control" name="pseudo" placeholder="pseudo de l\'utilisateur" value="'.$user["pseudoUser"].'" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Identifiant de connection</label>
                            <input type="text" class="form-control" name="identifiant" placeholder="identifiant de l\'utilisateur" value="'.$user["identifiantUser"].'" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>ID</label>
                            <input class="form-control" type="text" name="ID" value="'.$id.'" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>E-Mail</label>
                            <input type="text" class="form-control" name="email" placeholder="example@canardconfit.ch" value="'.$user["emailUser"].'" required>
                        </div>
                    </div>
                    <br><br>';
                } else {
                    echo "<div class=\"alert alert-primary\" role=\"alert\">Vous n'avez pas la permission !</div>";
                }
                echo '<h4>Changer le mot de passe de l\'utilisateur</h4>';
                
                if (asPermission($mysql, $userAdm, "admin.panel.modif.users.password")) {
                    echo '
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label>Nouveau mot de Passe</label>
                            <input type="password" class="form-control" name="pwd">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Répetez le Mot de Passe</label>
                            <input type="password" class="form-control" name="pwdRepeat">
                        </div>
                    </div>
                    <br><br>';
                } else {
                    echo "<div class=\"alert alert-primary\" role=\"alert\">Vous n'avez pas la permission !</div>";
                }
                ?>
                <h4>Permission de l'utilisateur</h4>
                <?php
                if (asPermission($mysql, $userAdm, "admin.panel.modif.users.permissions")) {
                    if (!empty($validatePerm)) {
                        echo "<div class=\"alert alert-success\" role=\"alert\">" . str_replace("/b/", "<b>", str_replace("/bf/", "</b>", str_replace("/br/", "<br/>", $validatePerm))) . "</div>";
                    }
                    echo '<table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">code</th>
                                <th scope="col">Description</th>
                            </tr>
                        </thead>
                        <tbody>';
                        $autPermID = getMysqlUserPermissionsID($mysql, $id);
                        foreach (getMysqlPermsID($mysql) as $idP){
                            $perm = getMysqlPermissionByID($mysql, $idP);
                            $authed = "";
                            if (in_array($idP, $autPermID)){
                                $authed = "checked";
                            }
                            echo '<tr>
                                    <th scope="row"><input type="checkbox" onclick="check_check()" class="permCheckbox" name="UserPerm-'.$idP.'" aria-label="Checkbox pour la permission de la ligne" '.$authed.'></th>
                                    <td>'.$perm["codePermission"].'</td>
                                    <td>'.$perm["nomPermission"].'</td>
                                  </tr>';
                        }
                        $m = "";
                        if (asMysqlAllRight($mysql, $user["identifiantUser"])) {$m = "checked";}    
                        echo '
                        </tbody>
                    </table>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <input type="checkbox" id="checkall" onclick="all_check(this.checked)" '.$m.'/>
                            <label>Tout Selectionner / Déselectionner</label>
                        </div>
                    </div>
                    <br><br>';
                } else {
                    echo "<div class=\"alert alert-primary\" role=\"alert\">Vous n'avez pas la permission !</div>";
                }
                ?>
                <div class="fixed-bottom" style="margin-left: 27.5%;">
                    <button class="btn btn-primary btn-lg" name="req_modif" value="rec" type="submit">Enregistrer les modifications</button>
                    <button class="btn btn-danger btn-lg" name="req_modif" value="annul" type="submit">Annuler les modifications</button>
                </div>
                <br><br>
            </form>
        </main>
    </body>
    <script type="text/javascript">
        <?php
        if (empty($errorsInfo) &&
           (!empty($validateInfo) ||
            !empty($validatePerm) ||
            !empty($validateGroup))){
            echo 'window.setTimeout(function () {

                    window.location = "users.php";
                }, 1000);';
        }
        ?>
        function all_check(check){
            var checkboxes = new Array(); 
            checkboxes = document.getElementsByClassName("permCheckbox");
            for (var i=0; i<checkboxes.length; i++) {
                if (checkboxes[i].type === 'checkbox') {
                  checkboxes[i].checked = check;
                }
            }
        }
        function check_check(){
            var checkboxes = new Array(); 
            var checked = true;
            checkboxes = document.getElementsByClassName("permCheckbox");
            for (var i=0; i<checkboxes.length; i++) {
                if (checkboxes[i].type === 'checkbox') {
                  if (!checkboxes[i].checked) {
                      checked = false;
                  }
                }
            }
            document.getElementById("checkall").checked = checked;
        }
    </script>
</html>
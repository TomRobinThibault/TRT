<?php
/*
 *
 *
 * Initialisation
 *
 *
 */
session_start();

$mysql = mysqli_connect("127.0.0.1", "root", "", "ecole_trt", "3306");
if (!$mysql){
    die ("Erreur de connection ". mysqli_error($mysql));
}
mysqli_select_db($mysql, "ecole_trt");
mysqli_set_charset($mysql, 'utf8');

if (isset($_SESSION["logged_user"])){
    updateMysqlLastUse($mysql, $_SESSION["logged_user"]);
}

/*
 *
 *
 * Function acces to page (Permissions, groups)
 *
 *
 */
function asPermission($mysql, $user, $code){

    $idUser = getMysqlIdUserByUser($mysql, $user);
    $idPerm = getMysqlIdPermissionByCode($mysql, $code);

    $result = mysqli_query($mysql, "SELECT idPermission FROM acceder WHERE idUser='".$idUser."' AND idPermission='".$idPerm."';");

    if (!empty($result) && mysqli_num_rows($result) == 1) {
        return true;
    } else {
        return false;
    }
}
function asPermissionArray($mysql, $user, $array){

    $idUser = getMysqlIdUserByUser($mysql, $user);
    foreach ($array as $code){
        $idPerm = getMysqlIdPermissionByCode($mysql, $code);

        $result = mysqli_query($mysql, "SELECT idPermission FROM acceder WHERE idUser='".$idUser."' AND idPermission='".$idPerm."';");

        if (empty($result)) {
            return false;
        }
    }
    return true;
}
function isInGroup($mysql, $user, $nom){

    $idUser = getMysqlIdUserByUser($mysql, $user);
    $idGroup = getMysqlIdGroupByName($mysql, $nom);

    $result = mysqli_query($mysql, "SELECT idGroupe FROM appartenir WHERE idUser='".$idUser."' AND idGroupe='".$idGroup."';");

    if (!empty($result) && mysqli_num_rows($result) == 1) {
        return true;
    } else {
        return false;
    }
}
function viewMysqlAllowedButton($mysql, $user, $code, $buttoncode) {
    if (asPermission($mysql, $user, $code)){
        echo $buttoncode;
    }
}
function kickNoAccessPage($mysql, $user, $code){
    if (!asPermission($mysql, $user, $code)){
        header("Location: ../../index.php");
    }
}
function kickNoAccessPageArray($mysql, $user, $array){
    if (is_array($array)){
        foreach ($array as $code){
            if (asPermission($mysql, $user, $code)){
                return;
            }
        }
        header("Location: ../index.php");
    }
}
function asMysqlAllRight($mysql, $identifiant){
    foreach (getMysqlPermsID($mysql) as $idP){
        if (!asPermission($mysql, $identifiant, getMysqlPermissionByID($mysql, $idP)["codePermission"])){
            return false;
        }
    }
    return true;
}


/*
 *
 *
 * Function MYSQL
 *
 *
 */
function MysqlChangePerm($mysql, $user, $code, $bool){
    $idUser = getMysqlIdUserByUser($mysql, $user);
    $idPerm = getMysqlIdPermissionByCode($mysql, $code);
    if (asPermission($mysql, $user, $code)){
        mysqli_query($mysql, "DELETE FROM acceder WHERE idUser=$idUser AND idPermission=$idPerm;");
    }
    if ($bool){
        MysqlAddUserPermission($mysql, $code, $user);
    }
}
function MysqlAddUserPermission($mysql, $code, $user){
    $idUser = getMysqlIdUserByUser($mysql, $user);
    $idPerm = getMysqlIdPermissionByCode($mysql, $code);
    mysqli_query($mysql, "INSERT INTO acceder(idUser, idPermission) VALUES ('$idUser', '$idPerm');");
}
function getMysqlPermsID($mysql){
    $result = mysqli_query($mysql, "SELECT idPermission FROM permission;");
    $ret = array();

    $i = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $ret[$i] = $row["idPermission"];
        $i+=1;
    }

    return $ret;
}
function getMysqlUserPermissionsID($mysql, $id){

    $result = mysqli_query($mysql, "SELECT idPermission FROM acceder WHERE idUser=$id;");
    $ret = array();

    $i = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $ret[$i] = $row["idPermission"];
        $i+=1;
    }

    return $ret;
}
function getMysqlPermissionByID($mysql, $id){
    $result = mysqli_query($mysql, "SELECT * FROM permission WHERE idPermission=$id;");

    return mysqli_fetch_assoc($result);
}
function getMysqlIdUserByUser($mysql, $user){

    $result = mysqli_query($mysql, "SELECT idUser FROM utilisateur WHERE identifiantUser='".$user."';");

    $id = mysqli_fetch_row($result);

    return $id[0];
}
function getMysqlIdPermissionByCode($mysql, $code){

    $result = mysqli_query($mysql, "SELECT idPermission FROM permission WHERE codePermission='".$code."';");

    $id = mysqli_fetch_row($result);

    return $id[0];
}
function getMysqlUserByEmail($mysql, $email){

    $result = mysqli_query($mysql, "SELECT identifiantUser FROM utilisateur WHERE emailUser='".$email."';");

    $user = mysqli_fetch_row($result);

    return $user[0];
}
function isMysqlLogged($mysql, $user){
    if (isset($user) && isMysqlUserExist($mysql, $user)){
        return true;
    } else {
        return false;
    }
}
function Mysqldelog($mysql, $user, $isRedirected, $redirection){
    if (isMysqlLogged($mysql, $user)){
        session_destroy();

        if ($isRedirected){
            header("Location: ".$redirection);
        }
    }
}
function isMysqlUserExist($mysql, $user){

    $result = mysqli_query($mysql, "SELECT identifiantUser FROM utilisateur WHERE identifiantUser='".$user."';");

    if (!empty($result) && mysqli_num_rows($result) == 1){
        return true;
    } else {
        return false;
    }
}
function isMysqlEmailExist($mysql, $email){

    $result = mysqli_query($mysql, "SELECT emailUser FROM utilisateur WHERE emailUser='".$email."';");

    if (!empty($result) && mysqli_num_rows($result) == 1){
        return true;
    } else {
        return false;
    }
}
function isMysqlUserPassword($mysql, $user, $pwd){
    $result = mysqli_query($mysql, "SELECT hashUser FROM utilisateur WHERE identifiantUser='".$user."';");

    $send_pwd = md5($pwd);
    $db_pwd = mysqli_fetch_row($result);

    if ($db_pwd[0] == $send_pwd){
        return true;
    } else {
        return false;
    }
}
function MysqlLoginUser($mysql, $user, $isRedirected, $redirection){
    $_SESSION['logged_user'] = $user;

    if ($isRedirected) {
        header("Location: ".$redirection);
    }
}
function MysqlRegisterNewUser($mysql, $pseudoUser, $identifiantUser, $email, $pwdUser){
    $hashUser = md5($pwdUser);

    $dateCreation = date("y/m/d H:i:s");

    $result = mysqli_query($mysql, "INSERT INTO utilisateur(pseudoUser, identifiantUser, emailUser, hashUser, dateCreation, dateLastUtilisation) VALUES ('".$pseudoUser."', '".$identifiantUser."', '".$email."', '".$hashUser."', '".$dateCreation."', '".$dateCreation."');");

    return $result;
}
function updateMysqlLastUse($mysql, $user){

    $date= date("y/m/d H:i:s");

    $result = mysqli_query($mysql, "UPDATE utilisateur SET dateLastUtilisation='$date' WHERE identifiantUser='$user';");

    return $result;
}
function getMysqlUsers($mysql){
    $result = mysqli_query($mysql, "SELECT * FROM utilisateur;");

    $ret = array();

    $i = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $ret[$i] = $row;
        $i+=1;
    }
    return $ret;
}
function getMysqlUserById($mysql, $id){
    $result = mysqli_query($mysql, "SELECT * FROM utilisateur WHERE idUser=$id;");

    return mysqli_fetch_assoc($result);
}
function updateMysqlUserChamp($mysql, $id, $var, $value){

    $result = mysqli_query($mysql, "UPDATE utilisateur SET $var='$value' WHERE idUser='$id';");

    return $result;
}
function isMysqlModifChamp($mysql, $id, $var, $value){

    $result = mysqli_query($mysql, "SELECT ".$var." FROM utilisateur WHERE idUser='".$id."';");

    $row = mysqli_fetch_row($result);

    return $row[0] != $value;
}


/*
 *
 *
 * Function Post
 *
 *
 */
function MysqlAddPost($mysql, $titrePost, $descPost, $identifiantUser){

    $dateCreation = date("y/m/d H:i:s");

    $idUser = getMysqlIdUserByUser($mysql, $identifiantUser);

    mysqli_query($mysql, "INSERT INTO post(titrePost, descPost, dateCreation, dateLastModification, idUser) VALUES ('".$titrePost."', '".$descPost."', '".$dateCreation."', '".$dateCreation."', '".$idUser."');");
}
function getMysqlPosts($mysql){
    $result = mysqli_query($mysql, "SELECT * FROM post;");

    $ret = array();

    $i = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $ret[$i] = $row;
        $i+=1;
    }
    return $ret;
}

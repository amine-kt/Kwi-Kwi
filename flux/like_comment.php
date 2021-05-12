<?php
session_start();
require_once('../utils/db_connect.php'); //appel la connexion à la bdd grâce au fichier db_connect.php
require_once('../utils/function.php');

$idcomment = $_POST["idcomment"];
$id_user = $_SESSION["user"]["id_user"];

$plus = "UPDATE comment SET `like` = `like`+ 1 WHERE idcomment = {$idcomment}";

$moin = "UPDATE comment SET `like` = `like`- 1 WHERE idcomment = {$idcomment}";

$count = "SELECT COUNT(*) AS liked FROM `like_comment` WHERE user_id_user = {$id_user} && comment_idcomment= {$idcomment}";

$insert = " INSERT INTO `like_comment` (user_id_user,comment_idcomment) VALUES ({$id_user},{$idcomment})";

$delete = "DELETE FROM `like_comment` WHERE `like_comment`.`user_id_user` = {$id_user} AND `like_comment`.`comment_idcomment` = {$idcomment} ";

$res = $db->query($count);
$data = mysqli_fetch_assoc($res);

if ($data['liked'] != 0) {
    if ($db->query($moin)) {
        $db->query($delete);
        echo json_encode(['success' => "true 1"]);
    } else {
        echo json_encode(['success' => "false 2"]);
    }
} else {
    if ($db->query($plus)) {
        $db->query($insert);
        echo json_encode(['success' => "true 3"]);
    } else {
        echo json_encode(['success' => "false 4"]);
    }
}
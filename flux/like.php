<?php
session_start();
require_once('../utils/db_connect.php'); //appel la connexion à la bdd grâce au fichier db_connect.php
require_once('../utils/function.php');

$id_publi = $_POST["id_publi"];
$id_user = $_SESSION["user"]["id_user"];




$plus = "UPDATE publication SET `like` = `like`+ 1 WHERE idpublication = {$id_publi}";

$moin = "UPDATE publication SET `like` = `like`- 1 WHERE idpublication = {$id_publi}";

$count = "SELECT COUNT(*) AS liked FROM `like` WHERE user_id_user = {$id_user} && publication_idpublication= {$id_publi}";

$insert = " INSERT INTO `like` (user_id_user,publication_idpublication) VALUES ({$id_user},{$id_publi})";

$delete = "DELETE FROM `like` WHERE `like`.`user_id_user` = {$id_user} AND `like`.`publication_idpublication` = {$id_publi} ";

$res = $db->query($count);
$data = mysqli_fetch_assoc($res);

if ($data['liked'] != 0) {
    if ($db->query($moin)) {
        $db->query($delete);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    if ($db->query($plus)) {
        $db->query($insert);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}

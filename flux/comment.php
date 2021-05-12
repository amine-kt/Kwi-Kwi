<?php
session_start();
require_once('../utils/db_connect.php'); //appel la connexion à la bdd grâce au fichier db_connect.php
require_once('../utils/function.php');


$id_publi = $_POST['idpubli'];

$req = "SELECT idcomment,content,`like`,date_comm,username,picture_profile FROM comment c INNER JOIN `user` u ON c.user_id_user = u.id_user WHERE publication_idpublication = {$id_publi} GROUP BY date_comm DESC";

$req2 = "SELECT COUNT(*) AS numb_comm FROM comment WHERE publication_idpublication = {$id_publi}";
$count = $db->query($req2);
$data=mysqli_fetch_assoc($count);

if ($res = $db->query($req)) {
    echo json_encode(['success' => true, 'result' => resultAsArray($res), 'number' =>$data['numb_comm']]);
} else {
    echo json_encode(['success' => 'false']);
}

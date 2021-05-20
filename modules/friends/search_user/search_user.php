<?php
session_start();
require_once('../../../utils/db_connect.php'); //appel la connexion à la bdd grâce au fichier db_connect.php
require_once('../../../utils/function.php');
require('../../../flux/vendor/autoload.php');


if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $req = "SELECT username FROM `user`"; // Requête slq demandans l'username et le mot de passe de l'username
    $res = $db->query($req); // Execute la requête sql
    $data = mysqli_fetch_assoc($res);
    echo ($data['username']);
}

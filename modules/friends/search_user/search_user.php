<?php
session_start();
require_once('../../../utils/db_connect.php'); //appel la connexion à la bdd grâce au fichier db_connect.php
require_once('../../../utils/function.php');
require('../../../flux/vendor/autoload.php');


if ($_SERVER["REQUEST_METHOD"] == "GET") {

    // $req = $db->query("SELECT username FROM user WHERE id_user = 0"); //? Select all the article
    $username = mysqli_query($db, "SELECT username FROM user WHERE id_user = 0");

    echo json_encode(['success' => true, 'user' => $username]);
}

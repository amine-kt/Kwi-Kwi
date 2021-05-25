<?php
session_start();

require_once('../../utils/db_connect.php'); //appel la connexion à la bdd grâce au fichier db_connect.php
require_once('../../utils/function.php'); // Fait appel au fichier php des fonctions



$role = $_SESSION['user']['role'];

if($role == "administrator"){
    echo json_encode(['success'=> true]);
}else{
    echo json_encode(['success'=> false]);
}
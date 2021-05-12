<?php
session_start();
require_once('../utils/db_connect.php'); //appel la connexion à la bdd grâce au fichier db_connect.php
require_once('../utils/function.php');

$publication_err = NULL;

$publication = mysqli_real_escape_string($db, $_POST['publication']);
$id_user = $_SESSION['user']['id_user'];
$datetime = date("Y-m-d H:i:s");

// ____________________ Vérification du KWIKWI ____________________
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($publication))) {
        $publication_err = "*veuillez saisir du texte si vous voulez poster";
    } elseif (strlen(trim($publication)) > 255) {
        $publication_err = "* vous avez dépassez le nombre de caractère maximum";
    }

    // __________________ Test avant l'envoie à la bdd __________________

    if ($publication_err != NULL) {
        echo json_encode(['success' => false, 'publication_err' => $publication_err]);
        die();
    } else {
        $sql = "INSERT INTO publication (content,date_publi,user_id_user) VALUES ('{$publication}','{$datetime}','{$id_user}')";
        $db->query($sql);
        echo json_encode(['success' => true]);
    }
}

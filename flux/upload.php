<?php
session_start(); // Démare la session
require_once('../utils/db_connect.php'); // Fait appel au fichier php de connexion à la bdd
require_once('../utils/function.php'); // Fait appel au fichier php des fonctions

$id_user = $_SESSION['user']['id_user']; // Récupère l'id de l'user
$file_err = NULL;

if (isset($_FILES['file']['name'])) {

    $location = "../images/$id_user/picture_profile/{$_FILES['file']['name']}"; // Destination
    $filepath = strtolower(pathinfo($location, PATHINFO_EXTENSION));

    if ($filepath != "jpg" && $filepath != "png" && $filepath != "jpeg") { // Vérifie si le forma de l'image est différent de jpg png ou jpeg
        $file_err = "Le fichier n'est pas une image valide, uniquement les .jpg .png ou .jpeg sont autorisé."; // Déclare la variable d'erreur
    }

    if (file_exists($location)) { // Vérifie si le fichier existe déjà
        $file_err = "Le fichier est déjà uploader."; // Déclare la variable d'erreur
    }

    //  Vérification extension du fichier
    if ($file_err === NULL) {

        $files = glob("../images/$id_user/picture_profile/*"); // Récupère tout les fichier à l'emplacemenet ciblé
        foreach ($files as $file) { // parcours des fichier
            if (is_file($file)) { // Si il y a fichier
                unlink($file); // Suprime les fichier
            }
        }

        if (move_uploaded_file($_FILES['file']['tmp_name'], $location)) { // SI l'envoie du fichier se fait à la destination
            $sql = "UPDATE user SET picture_profile='$location' WHERE id_user=$id_user"; // Prépare la requête slq
            $db->query($sql); // Envoie à la bdd

            echo json_encode(['success' => true, 'picture_profile' => $location]);
            die();
        } else {
            $file_err = "Une erreur innatendue est survenue";
            echo json_encode(['success' => false, 'file_err' => $file_err]);
            die();
        }
    } else {
        echo json_encode(['success' => false, 'file_err' => $file_err]);
        die();
    }
}

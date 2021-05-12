<?php
session_start(); // Démare la session
require_once('../utils/db_connect.php'); // Fait appel au fichier php de connexion à la bdd
require_once('../utils/function.php'); // Fait appel au fichier php des fonctions

$id_user = $_SESSION['user']['id_user']; // Récupère l'id de l'user
$target_dir = "../images/$id_user/picture_profile/"; // Chemin ou l'image va s'enregistrer
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]); // Chemin avec l'image ou elle va être enregistrer
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {

    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        // echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        // echo "File is not an image.";
        $uploadOk = 0;
    }
}

// Check if file already exists
if (file_exists($target_file)) { // Vérifie si le fichier existe déjà
    // echo "Sorry, file already exists.";
    $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) { // Vérifie si la taille de l'image est supérieur à 500 Mo
    // echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") { // Vérifie le forma de l'image
    // echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

if ($uploadOk == 0) { // Test si uploardOk est à 0
    // echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $_SESSION['user']['picture_profile'] = $target_dir . ($_FILES["fileToUpload"]["name"]);
        $sql = "UPDATE user SET picture_profile='{$_SESSION['user']['picture_profile']}' WHERE id_user='{$_SESSION['user']['id_user']}'"; // Prépare la requête slq
        $db->query($sql); // Envoie à la bdd
        // echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded. Test " . $_SESSION['user']['picture_profile'];
    } else {
        // echo "Sorry, there was an error uploading your file.";
    }
}

header('Location: ../html/profile.html');

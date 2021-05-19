<?php
session_start();
require_once('../../utils/db_connect.php');
require_once('../../utils/function.php');
require('../../flux/vendor/autoload.php');

$regex_password = "/(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/";

$password_err = $new_password_err = $confirm_new_password_err = NULL;

$password = mysqli_real_escape_string($db, $_POST['password']);
$new_password = mysqli_real_escape_string($db, $_POST["new_password"]);
$confirm_new_password = mysqli_real_escape_string($db, $_POST["confirm_new_password"]);

$password_bdd = $_SESSION['user']['password'];

// ___________ Début des test des input ___________
if ($_SERVER["REQUEST_METHOD"] == "POST") { // Si on a requête avec une méthode POST (donc un envoie de formulaire)

    if (empty(trim($password))) { // Test si le mot de passe est vide
        $password_err = "*Mot de passe vide."; // Déclare le message d'erreur dans la variable
    } elseif (!preg_match($regex_password, $password)) { // Test le regex sur le password
        $password_err = "*Le mot de passe doit contenir au moins 1 majuscule, 1 minusclue, 1 chiffre ou caractère spécial et doit faire une taille de 8 carractères ou plus."; // Si ne rentre pas dans le regex alors déclaire la variable d'erreur rappelant les conditions nécessaires.
    }

    if (empty(trim($new_password))) { // Test si le mot de passe est vide
        $new_password_err = "*Mot de passe vide."; // Déclare le message d'erreur dans la variable
    } elseif (password_verify($new_password, $password_bdd)) { // Test si le mot de passe actuel est le même que le nouveau
        $new_password_err = "*Ceci est votre mot de passe actuel."; // Déclare le message d'erreur dans la variable
    }

    if (empty(trim($confirm_new_password))) { // Test si le mot de passe est vide
        $confirm_new_password_err = "*Mot de passe vide."; // Déclare le message d'erreur dans la variable
    } elseif (($new_password) != ($confirm_new_password)) { // Compare les deux mot de passe
        $confirm_new_password_err = "*Les mots de passes ne correspondent pas"; // Déclare la variable d'erreur si ils ne corespondent pas
    }

    // ___________ Test des messages d'erreur avant toute vérification ______________
    if (($password_err != NULL) || ($new_password_err != NULL) || ($confirm_new_password_err != NULL)) {
        echo json_encode(['success' => false, 'password_err' => $password_err, 'new_password_err' => $new_password_err, 'confirm_new_password_err' => $confirm_new_password_err]);
        die(); // Stop l'envoie au js
    } else {
        if (password_verify($password, $password_bdd)) {

            $new_password = password_hash($new_password, PASSWORD_DEFAULT); // hash le mot de passe et le replace dans la variable password
            $username_bdd = $_SESSION['user']['username'];
            $sql = "UPDATE user SET password='{$new_password}' WHERE username='{$username_bdd}'"; // Prépare la requête slq
            $db->query($sql); // Envoie à la bdd

            $_SESSION['user']['password'] = $new_password;
            echo json_encode(['success' => true]);
            die();
        } else {
            $password_err = "*Mot de passe incorrecte"; // Déclare la variable d'erreur au mot de passe
            echo json_encode(['success' => false, 'password_err' => $password_err]); // Envoie les erreur au js avec le succes false
            die(); // Si le mot de passe ne correspond pas alors
        }
    }
}

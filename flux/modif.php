<?php
session_start();
require_once('../utils/db_connect.php');
require_once('../utils/function.php');

$regex_mail = '/(?:[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/';
$regex_username = "/^[a-zA-Z][a-zA-Z0-9-_\.]{5,}$/";

$username_err = $email_err = $password_err = NULL;

//? la fonction mysqli_real_escape_string empeche l'utilisateur de faire des injections qui lui permettron d'obtenir des informations auquelles il ne devrait pas avoir accès
$username = mysqli_real_escape_string($db, $_POST['username']);
$email = mysqli_real_escape_string($db, $_POST["email"]);
$password = mysqli_real_escape_string($db, $_POST["password"]);

$req = "SELECT username, firstname, lastname, email, birthdate, gender, picture_profile, password FROM `user` WHERE id_user = {$_SESSION['user']['id_user']}"; // Requête slq demandans l'username et le mot de passe de l'username
$res = $db->query($req); // Execute la requête sql

$data = mysqli_fetch_assoc($res);
// print_r($data);

// Selecteurs pour les vérification initial
$select_email = $data['email']; // Selecteur sql avec la fonction mysqli_query pour tester si l'email est déjà prit ou non plus bas dans le code
$select_username = $data['username']; // Selecteur sql avec la fonction mysqli_query pour tester si l'username est déjà prit ou non plus bas dans le code
// Selecteurs pour les vérification final
$select_email_bdd = mysqli_query($db, "SELECT email FROM user WHERE email = '" . $email . "'"); // Selecteur sql avec la fonction mysqli_query pour tester si l'email est déjà prit ou non plus bas dans le code
$select_username_bdd = mysqli_query($db, "SELECT username FROM user WHERE username = '" . $username . "'"); // Selecteur sql avec la fonction mysqli_query pour tester si l'username est déjà prit ou non plus bas dans le code

//? toute les conditions que vous vouyez permettent de verifier si les informations qu'il veut modifier sont au bon format puis de l'envoyer a la base de données
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ___________________ Vérification du email _______________________________
    if (empty(trim($email))) { // Test si l'email est vide
        $email = $select_email;
    } elseif (!preg_match($regex_mail, $email)) { // Test le regex de l'email
        $email_err = "*L'email n'est pas au bon format"; // Déclare la variable d'erreur
    } elseif (strlen(trim($email)) > 253) { // Test la longueur de l'email si supérieur à 253 caractères
        $email_err = "*L'email est trop grande"; // Si supérieur alors déclare la variable d'erreur
    } elseif ($select_email != $email) { // Test si l'email est déjà prit avec la fonction mysqli_num_rows et le sélécteur préparé plus haut dans le code
        if (mysqli_num_rows($select_email_bdd)) { // Test si l'email est déjà prit avec la fonction mysqli_num_rows et le sélécteur préparé plus haut dans le code
            $email_err = "*L'email est déjà prise"; // Si déjà prise alors déclare la variable d'erreur
        }
    }
    // ______________________ Vérification du format de l'Username _________________________
    if (empty(trim($username))) { // Test si l'username est vide
        $username = $select_username;
    } elseif (!preg_match($regex_username, $username)) { // Test le regex sur l'username
        $username_err = "*L'username n'est pas au bon format (minimum 6 carractères)"; // déclare la variable d'erreur
    } elseif (strlen(trim($username)) > 44) { // Test la longeur de l'username
        $username_err = "*L'username est trop grand"; // Si trop grand déclare la variable d'erreur
    } elseif ($select_username != $username) {
        if (mysqli_num_rows($select_username_bdd)) { // Test si l'email est déjà prit avec la fonction mysqli_num_rows et le sélécteur préparé plus haut dans le code
            $username_err = "*L'username est déjà prit"; // Si oui déclare la variable d'erreur
        }
    }
    // __________________ Vérification du password ____________________
    if (empty(trim($password))) { // test si le mot de passe est vide
        $password_err = "*Veuillez entré votre mot de passe"; // Si vide déclare la variable d'erreur
    }

    // ___________ Test des messages d'erreur avant toute vérification ______________
    if (($username_err != NULL) || ($password_err != NULL) || ($email_err != NULL)) {
        echo json_encode(['success' => false, 'username_err' => $username_err, 'email_err' => $email_err, 'password_err' => $password_err]);
        die(); // Stop l'envoie au js
    } else { // Si pas d'erreur alors
        // ______________ Vérification du password avant la vérification ______________
        $password_bdd = $data['password'];
        if (password_verify($password, $password_bdd)) {
            $username_bdd = $data['username'];
            $sql = "UPDATE user SET username='{$username}', email = '{$email}' WHERE username='{$username_bdd}'"; // Prépare la requête slq
            $db->query($sql); // Envoie à la bdd
            $_SESSION['user']['email'] = $email;
            $_SESSION['user']['username'] = $username;
            echo json_encode(['success' => true, 'email' => $email, 'username' => $username]);
            die();
        } else {
            $password_err = "*Mot de passe incorrect"; // Si vide déclare la variable d'erreur
            echo json_encode(['success' => false, 'password_err' => $password_err]);
            die();
        }
    }
}

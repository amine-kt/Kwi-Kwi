<?php
session_start();

require_once('../utils/db_connect.php'); //appel la connexion à la bdd grâce au fichier db_connect.php
require_once('../utils/function.php'); // Fait appel au fichier php des fonctions

// Liste de tout les regex
$regex_date = "/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/";
$regex_mail = '/(?:[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/';
$regex_password = "/(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/";
$regex_name = "/^[a-zA-Z][a-zA-Z-' ]{2,}$/";
$regex_username = "/^[a-zA-Z][a-zA-Z0-9-_\.]{5,}$/";

// déclaration des variables erreures en NULL par défault
$firstname_err = $lastname_err = $birthdate_err = $email_err = $username_err = $password_err = $confirm_password_err = $gender_err = NULL;

//_______________ Stockage du contenue des input dans des variables _______________________________
$firstname = mysqli_real_escape_string($db, $_POST["firstname"]); // stock l'envoie de l'input firstname en plus d'empecher toute injection sql grâce à mysqli_real_escape_string
$lastname = mysqli_real_escape_string($db, $_POST["lastname"]); // stock l'envoie de l'input lastname en plus d'empecher toute injection sql grâce à mysqli_real_escape_string
$birthdate = mysqli_real_escape_string($db, $_POST["birthdate"]); // stock l'envoie de l'input birthdate en plus d'empecher toute injection sql grâce à mysqli_real_escape_string
$email = mysqli_real_escape_string($db, $_POST["email"]); // stock l'envoie de l'input email en plus d'empecher toute injection sql grâce à mysqli_real_escape_string
$username = mysqli_real_escape_string($db, $_POST['username']); // stock l'envoie de l'input username en plus d'empecher toute injection sql grâce à mysqli_real_escape_string
$password = mysqli_real_escape_string($db, $_POST["password"]); // stock l'envoie de l'input password en plus d'empecher toute injection sql grâce à mysqli_real_escape_string
$confirm_password = mysqli_real_escape_string($db, $_POST["confirm_password"]); // stock l'envoie de l'input confirm_password en plus d'empecher toute injection sql grâce à mysqli_real_escape_string
$gender = mysqli_real_escape_string($db, $_POST["gender"]); // stock l'envoie de l'input gender en plus d'empecher toute injection sql grâce à mysqli_real_escape_string

// Selecteurs pour les vérification
$select_email = mysqli_query($db, "SELECT email FROM user WHERE email = '" . $email . "'"); // Selecteur sql avec la fonction mysqli_query pour tester si l'email est déjà prit ou non plus bas dans le code
$select_username = mysqli_query($db, "SELECT username FROM user WHERE username = '" . $username . "'"); // Selecteur sql avec la fonction mysqli_query pour tester si l'username est déjà prit ou non plus bas dans le code

// Début des vérification des valeurs :
if ($_SERVER["REQUEST_METHOD"] == "POST") { // Si on a requête avec une méthode POST (donc un envoie de formulaire)

    // __________________ Vérification du Firstname ______________________
    if (empty(trim($firstname))) { // Test si le firstname est vide
        $firstname_err = "*Le Firstname est vide"; // Si vide déclare la variable d'erreur
    } elseif (!preg_match($regex_name, $firstname)) { // Test du regex sur le firstname
        $firstname_err = "*Le Firstname n'est pas au bon format"; // Si le firstname ne rentre pas dans le regex alors déclare la variable d'erreur
    } elseif (strlen(trim($firstname)) > 44) { // Test la longeur du fristname si elle est supérieur à 44
        $firstname_err = "*Le firstname est trop grand"; // Si oui déclare la varianble d'erreur
    }

    // __________________ Vérification du Lastname _____________________
    if (empty(trim($lastname))) { // Test si le Lastname set vide
        $lastname_err = "*Le Lastname est vide"; // Si vide déclare la variable d'erreur
    } elseif (!preg_match($regex_name, $lastname)) { // Test du regex lastname
        $lastname_err = "*Le Lastname n'est pas au bon format"; // Si le lastname ne rentre pas de le regex alors déclare la variable d'erreur
    } elseif (strlen(trim($lastname)) > 44) { // Test la longueur du lastname si elle est supérieur à 44
        $lastname_err = "*Le Lastname est trop grande"; // Si supérieur alors déclare la variable d'erreur
    }

    // ______________________ Vérification du format de la date de naissance _________________________
    if (empty(trim($birthdate))) { // Test si la date de naissance est vide
        $birthdate_err = "*La birthdate est vide"; // Si vide déclare la variable d'erreur
    } elseif (!preg_match($regex_date, $birthdate)) { // Test le regex de la date
        $birthdate_err = "*La date n'est pas au bon format"; // Déclare la variable d'erreur si au mauvais format
    }


    // ___________________ Vérification du email _______________________________
    if (empty(trim($email))) { // Test si l'email est vide
        $email_err = "*L'email est vide"; // Si vide déclare une erreur dans une variable
    } elseif (!preg_match($regex_mail, $email)) { // Test le regex de l'email
        $email_err = "*L'email n'est pas au bon format"; // Déclare la variable d'erreur
    } elseif (strlen(trim($email)) > 253) { // Test la longueur de l'email si supérieur à 253
        $email_err = "*L'email est trop grande"; // Si supérieur alors déclare la variable d'erreur
    } elseif (mysqli_num_rows($select_email)) { // Test si l'email est déjà prit avec la fonction mysqli_num_rows et le sélécteur préparé plus haut dans le code
        $email_err = "*L'email est déjà prise"; // Si déjà prise alors déclare la variable d'erreur
    }

    // ___________________________ Genre ______________________________
    if (empty(trim($gender))) { // test si aucun genre n'est séléctionné
        $gender_err = "*Aucun genre séléctionné"; // Si aucun alors déclare la variable d'erreur
    } elseif (($gender != 'male') && ($gender != 'femal') && ($gender != 'other')) { // Vérifie que l'envoie du genre na pas été modifier au code source de la page
        $gender_err = "*Ceci n'est pas un genre valide, veuillez à ne pas modifier le code source de la page lors de l'inscription."; // Si c'est le cas déclare la variable d'erreur
    }


    // ______________________ Vérification du format de l'Username _________________________
    if (empty(trim($username))) { // Test si l'username est vide
        $username_err = "*Le Username est vide"; // Si vide déclare la variable d'erreur
    } elseif (!preg_match($regex_username, $username)) { // Test le regex sur l'username
        $username_err = "*L'username n'est pas au bon format (minimum 6 carractères)"; // déclare la variable d'erreur
    } elseif (strlen(trim($username)) > 44) { // Test la longeur de l'username
        $username_err = "*L'username est trop grand"; // Si trop grand déclare la variable d'erreur
    } elseif (mysqli_num_rows($select_username)) { // Test si l'email est déjà prit avec la fonction mysqli_num_rows et le sélécteur préparé plus haut dans le code
        $username_err = "*L'username est déjà prit"; // Si oui déclare la variable d'erreur
    }


    // __________________ Vérification du password ____________________
    if (empty(trim($password))) { // test si le mot de passe est vide
        $password_err = "*Veuillez entré un mot de passe"; // Si vide déclare la variable d'erreur
    } elseif (!preg_match($regex_password, $password)) { // Test le regex sur le password
        $password_err = "*Le mot de passe doit contenir au moins 1 majuscule, 1 minusclue, 1 chiffre ou caractère spécial et doit faire une taille de 8 carractères ou plus."; // Si ne rentre pas dans le regex alors déclaire la variable d'erreur rappelant les conditions nécessaires.
    }

    // _______________ Confirmation du password ____________
    if (empty(trim($confirm_password))) { // Test si la confirmation du mot de passe est vide
        $confirm_password_err = "*Veuillez confirmer le mot de passe"; // Si vide déclare la variable d'erreur
    } elseif (($password) != ($confirm_password)) { // Compare les deux mot de passe
        $confirm_password_err = "*Les mots de passes ne correspondent pas"; // Déclare la variable d'erreur si ils ne corespondent pas
    }

    // __________________ Test avant l'envoie à la bdd __________________
    if (($firstname_err != NULL) || ($lastname_err != NULL) || ($birthdate_err != NULL) || ($email_err != NULL) || ($gender_err != NULL) || ($username_err != NULL) || ($password_err != NULL) || ($confirm_password_err != NULL)) { // Test si il n'y à aucun message d'erreur déclaré
        // Si il y a au moins un message d'erreur alors :
        echo json_encode(['success' => false, 'firstname_err' => $firstname_err, 'lastname_err' => $lastname_err, 'birthdate_err' => $birthdate_err, 'email_err' => $email_err, 'gender_err' => $gender_err, 'username_err' => $username_err, 'password_err' => $password_err, 'confirm_password_err' => $confirm_password_err]); // renvoie l'information js grâce à la fonction "echo json_encode" que "success = false", ainsi que tout les messages d'erreurs
        die(); // stop l'envoie d'info au js
    } else {


        $password = password_hash($password, PASSWORD_DEFAULT); // hash le mot de passe et le replace dans la variable password

        // Insertion dans la bdd
        $sql = "INSERT INTO `user` (firstname, lastname, birthdate, email, username, password, gender) VALUES ('{$firstname}', '{$lastname}', '{$birthdate}', '{$email}', '{$username}', '{$password}', '{$gender}')"; // Prépare la requête slq
        $db->query($sql); // Envoie à la bdd

        $req = "SELECT id_user, username, firstname, lastname, email, birthdate, gender, picture_profile FROM `user` WHERE username = '$username'"; // Requête slq demandans l'username et le mot de passe de l'username
        $res = $db->query($req); // Execute la requête sql

        if ($data = mysqli_fetch_assoc($res)) {
            $_SESSION['connected'] = true;
            $_SESSION['user'] = [
                'id_user' => $data['id_user'],
                'email' => $data['email'],
                'username' => $data['username']
            ];
            mkdir("../images/{$data['id_user']}/picture_profile", 0777, true); // 0777 correspond au maximum de droits possible et le "true" renvoie true en cas de succès.
            mkdir("../images/{$data['id_user']}/picture_post", 0777, true);
            echo json_encode(['success' => true, 'user' => $data]); // Envoie au js que c'est un succès
            die(); // stop l'envoie d'info au js
        }
        // $rep = smtpMailer($_SESSION['user']['email'], 'Bienvenue dans la Kwikwi-sphere', "Merci de votre inscription{$_SESSION['user']['username']}");
    }
}

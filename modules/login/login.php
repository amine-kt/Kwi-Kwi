<?php
session_start();

require_once('../../utils/db_connect.php'); // Fait appel au fichier php de connexion à la bdd
require_once('../../utils/function.php'); // Fait appel au fichier php des fonctions
require('../../flux/vendor/autoload.php');


//_______________ Stockage du contenue des input dans des variables _______________________________
$password = mysqli_real_escape_string($db, $_POST["password"]); // stock l'envoie de l'input password en plus d'empecher toute injection sql grâce à mysqli_real_escape_string
$username = mysqli_real_escape_string($db, $_POST['username']); // stock l'envoie de l'input username en plus d'empecher toute injection sql grâce à mysqli_real_escape_string

// déclaration des variables d'erreur en NULL par défault
$username_err = $password_err = NULL;

// ___________ Début des test des input ___________
if ($_SERVER["REQUEST_METHOD"] == "POST") { // Si on a requête avec une méthode POST (donc un envoie de formulaire)

    if (empty(trim($username))) { // Test si l'username est vide
        $username_err = "*Username vide."; // Déclare la variable d'erreur
    }

    if (empty(trim($password))) { // Test si le mot de passe est vide
        $password_err = "*Mot de passe vide."; // Déclare le message d'erreur dans la variable
    }

    // ___________ Test des messages d'erreur avant toute vérification ______________
    if (($username_err != NULL) || ($password_err != NULL)) {
        echo json_encode(['success' => false, 'username_err' => $username_err, 'password_err' => $password_err]);
        die(); // Stop l'envoie au js
    } else { // Si pas d'erreur alors
        // ____________ Début de la vérification des information envoyer _____________
        $req = "SELECT id_user, username, firstname, lastname, email, birthdate,role, gender, picture_profile,password, ban FROM `user` WHERE username = '$username'"; // Requête slq demandans l'username et le mot de passe de l'username
        $res = $db->query($req); // Execute la requête sql
        if ($data = mysqli_fetch_assoc($res)) { // Test si une corespondance dans la variable stock les résultat dans la variable

            if (password_verify(($password),$data["password"])) { // Vérifie le password en le comparant avec le hash du password de la bdd
                $_SESSION['user'] = [
                    'id_user' => $data['id_user'],
                    'email' => $data['email'],
                    'username' => $data['username'],
                    'role' => $data['role'],
                    'ban' => $data['ban']
                ];

               

                $_SESSION['connected'] = true;
                echo json_encode(['success' => true, 'user' => $data, 'role'=> $data['role'], 'ban'=>  $data['ban']]);
                die(); // Stop l'envoie au js
            } else { // Si le mot de passe ne correspond pas alors
                $password_err = "*Mot de passe incorrecte"; // Déclare la variable d'erreur au mot de passe
                echo json_encode(['success' => false, 'username_err' => $username_err, 'password_err' => $password_err, "passw"=> $data["password"]]); // Envoie les erreur au js avec le succes false
                die(); // Si le mot de passe ne correspond pas alors
            }
        } else { // Sinon avec aucun résultat avec l'username alors
            $username_err = "*Utilisateur introuvable"; // Déclaration de la variable d'ereur du username
            echo json_encode(['success' => false, 'username_err' => $username_err, 'password_err' => $password_err]); // Envoie les erreur au js avec le succes false
            die(); // Si le mot de passe ne correspond pas alors
        }
    }
}

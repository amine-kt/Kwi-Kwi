<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'kwikwi_db');

$db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($db === false) {
  die("ERROR: Could not connect. " . mysqli_connect_error());
}



// $host_name = 'db5002700201.hosting-data.io';
// $database = 'dbs2149590';
// $user_name = 'dbu1649034';
// $password = 'KE%gkptz/2sw7S/';

// $db = new mysqli($host_name, $user_name, $password, $database);

// if ($db->connect_error) {
//   die('<p>La connexion au serveur MySQL a échoué: ' . $db->connect_error . '</p>');
// } else {
//   echo '<p>Connexion au serveur MySQL établie avec succès.</p>';
// }

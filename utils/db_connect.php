<?php
// $servername = "db";
// $username = "root";
// $password = "";
// $dbname = "myshop";


// $db = new mysqli($servername, $username, $password, $dbname);


// if ($db->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }


define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'kwikwi_db');

/* Attempt to connect to MySQL database */
$db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($db === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

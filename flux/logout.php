<?php
session_start();

session_destroy();
// session_unset();

$_SESSION['connected'] = false;
// test

header("location: ../login.html");
exit;

<?php
session_start();
if (!isset($_SESSION["connected"])) {
    $_SESSION['connected'] = false;
}
echo json_encode(["connected" => $_SESSION['connected']]);

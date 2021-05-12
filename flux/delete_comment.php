<?php
session_start();
require_once('../utils/db_connect.php'); //appel la connexion à la bdd grâce au fichier db_connect.php
require_once('../utils/function.php');

$idcomment = $_POST['idcomment'];

$del_comm = "DELETE FROM comment WHERE idcomment = {$idcomment}";

$del_like = "DELETE FROM `like_comment` WHERE comment_idcomment = {$idcomment}";


    if($db->query($del_like)){
        if($db->query($del_comm)){
                echo json_encode(['success'=> true]);
        }
    }

<?php
session_start();
require_once('../utils/db_connect.php'); //appel la connexion à la bdd grâce au fichier db_connect.php
require_once('../utils/function.php');


$id_publi = $_POST['idpubli'];


$del_publi = "DELETE FROM publication WHERE idpublication = {$id_publi} ";

$del_comm = "DELETE FROM comment WHERE publication_idpublication = {$id_publi}";

$del_like = "DELETE FROM `like` WHERE publication_idpublication = {$id_publi}";


    if($db->query($del_comm)){
        if($db->query($del_like)){
            if($db->query($del_publi)){
                    echo json_encode(['success'=> true]);
            }
        }
    }
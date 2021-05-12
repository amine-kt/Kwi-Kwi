<?php
session_start();
require_once('../utils/db_connect.php'); //appel la connexion à la bdd grâce au fichier db_connect.php

$comment_err = NULL;

$comment = mysqli_real_escape_string($db, $_POST['comment']);
$id_publi = $_POST['id_publi'];
$id_user= $_SESSION['user']['id_user'];
$datetime = date("Y-m-d H:i:s");

// ____________________ Vérification du KWIKWI ____________________
if($_SERVER["REQUEST_METHOD"] == "POST"){
    echo $comment;
    if(empty(trim($comment))){
        $comment_err="*veuillez saisir du texte si vous voulez commenter";
    }elseif(strlen(trim($comment)) > 255){
        $comment_err = "* vous avez dépassez le nombre de caractère maximum";
    }

// __________________ Test avant l'envoie à la bdd __________________

if($comment_err != NULL){
    echo json_encode(['success'=> false,'comment_err'=>$comment_err]);
    die();
}else{
    $sql = "INSERT INTO comment (content,date_comm,user_id_user,publication_idpublication) VALUES ('{$comment}','{$datetime}','{$id_user}','{$id_publi}')";
    $db->query($sql);
    echo json_encode(['success'=> true]);
}

}
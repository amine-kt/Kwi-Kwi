<?php
session_start();
require_once('../utils/php/db_connect.php'); //appel la connexion à la bdd grâce au fichier db_connect.php
require_once('../utils/php/function.php');





switch($_POST['method']){
    case'add' :
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
        break;
        case'delete':
            $idcomment = $_POST['idcomment'];

$del_comm = "DELETE FROM comment WHERE idcomment = {$idcomment}";

$del_like = "DELETE FROM `like_comment` WHERE comment_idcomment = {$idcomment}";


    if($db->query($del_like)){
        if($db->query($del_comm)){
                echo json_encode(['success'=> true]);
        }
    }
        break;
        case'like':
            $idcomment = $_POST["idcomment"];
$id_user = $_SESSION["user"]["id_user"];

$plus = "UPDATE comment SET `like` = `like`+ 1 WHERE idcomment = {$idcomment}";

$moin = "UPDATE comment SET `like` = `like`- 1 WHERE idcomment = {$idcomment}";

$count = "SELECT COUNT(*) AS liked FROM `like_comment` WHERE user_id_user = {$id_user} && comment_idcomment= {$idcomment}";

$insert = " INSERT INTO `like_comment` (user_id_user,comment_idcomment) VALUES ({$id_user},{$idcomment})";

$delete = "DELETE FROM `like_comment` WHERE `like_comment`.`user_id_user` = {$id_user} AND `like_comment`.`comment_idcomment` = {$idcomment} ";

$res = $db->query($count);
$data = mysqli_fetch_assoc($res);

if ($data['liked'] != 0) {
    if ($db->query($moin)) {
        $db->query($delete);
        echo json_encode(['success' => "true 1"]);
    } else {
        echo json_encode(['success' => "false 2"]);
    }
} else {
    if ($db->query($plus)) {
        $db->query($insert);
        echo json_encode(['success' => "true 3"]);
    } else {
        echo json_encode(['success' => "false 4"]);
    }
}
            break;
    case'select':
$id_publi = $_POST['idpubli'];

$req = "SELECT idcomment,content,`like`,date_comm,username,picture_profile FROM comment c INNER JOIN `user` u ON c.user_id_user = u.id_user WHERE publication_idpublication = {$id_publi} GROUP BY date_comm DESC";

$req2 = "SELECT COUNT(*) AS numb_comm FROM comment WHERE publication_idpublication = {$id_publi}";
$count = $db->query($req2);
$data=mysqli_fetch_assoc($count);

if ($res = $db->query($req)) {
    echo json_encode(['success' => true, 'result' => resultAsArray($res), 'number' =>$data['numb_comm']]);
} else {
    echo json_encode(['success' => 'false']);
}
break;

default:
break;
}
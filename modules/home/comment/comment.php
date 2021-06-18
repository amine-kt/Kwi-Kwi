<?php
session_start();
require_once('../../../utils/db_connect.php'); //appel la connexion à la bdd grâce au fichier db_connect.php
require_once('../../../utils/function.php');
require('../../../flux/vendor/autoload.php');





switch ($_POST['method']) {
    case 'add':
        $comment_err = NULL;

        $comment = mysqli_real_escape_string($db, $_POST['comment']);
        $id_publi = $_POST['id_publi'];
        $id_user = $_SESSION['user']['id_user'];
        $datetime = date("Y-m-d H:i:s");

        // ____________________ Vérification du KWIKWI ____________________
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty(trim($comment))) {
                $comment_err = "*veuillez saisir du texte si vous voulez commenter";
            } elseif (strlen(trim($comment)) > 255) {
                $comment_err = "* vous avez dépassez le nombre de caractère maximum";
            }

            // __________________ Test avant l'envoie à la bdd __________________

            if ($comment_err != NULL) {
                echo json_encode(['success' => false, 'comment_err' => $comment_err]);
                die();
            } else {
                $sql = "INSERT INTO comment (content,date_comm,user_id_user,publication_idpublication) VALUES ('{$comment}','{$datetime}','{$id_user}','{$id_publi}')";
                $db->query($sql);
                echo json_encode(['success' => true]);
            }
        }
        break;
    case 'delete':
        $idcomment = $_POST['idcomment'];

        $del_comm = "DELETE FROM comment WHERE idcomment = {$idcomment}";

        $del_like = "DELETE FROM `like_comment` WHERE comment_idcomment = {$idcomment}";

        $del_report = "DELETE FROM reports_comm WHERE comment_idcomment = {$idcomment}";


        if ($db->query($del_like) && $db->query($del_report)) {
            if ($db->query($del_comm)) {
                echo json_encode(['success' => true]);
            }
        }
        break;
    case 'like':
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
        case 'report_c':
            $idcomment = $_POST["idcomm"];
            $id_user = $_SESSION["user"]["id_user"];
    
            $plus = "UPDATE comment SET reports = reports + 1 WHERE idcomment = {$idcomment}";
    
            $moin = "UPDATE comment SET reports = reports - 1 WHERE idcomment = {$idcomment}";
    
            $count = "SELECT COUNT(*) AS reported FROM reports_comm WHERE user_id_user = {$id_user} && comment_idcomment= {$idcomment}";
    
            $insert = " INSERT INTO reports_comm (user_id_user,comment_idcomment) VALUES ({$id_user},{$idcomment})";
    
            $delete = "DELETE FROM reports_comm WHERE reports_comm.`user_id_user` = {$id_user} AND reports_comm.`comment_idcomment` = {$idcomment} ";
    
            $res = $db->query($count);
            $data = mysqli_fetch_assoc($res);
    
            if ($data['reported'] != 0) {
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
    default:
        break;
}

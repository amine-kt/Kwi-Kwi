<?php
session_start();
require_once('../utils/php/db_connect.php'); //appel la connexion à la bdd grâce au fichier db_connect.php
require_once('../utils/php/function.php');




switch ($_POST['method']){

            case 'add':
                $publication_err = NULL;

$publication = mysqli_real_escape_string($db, $_POST['publication']);
$id_user = $_SESSION['user']['id_user'];
$datetime = date("Y-m-d H:i:s");
// ____________________ Vérification du KWIKWI ____________________

    if (empty(trim($publication))) {
        $publication_err = "*veuillez saisir du texte si vous voulez poster";
    } elseif (strlen(trim($publication)) > 255) {
        $publication_err = "* vous avez dépassez le nombre de caractère maximum";
    }

    // __________________ Test avant l'envoie à la bdd __________________

    if ($publication_err != NULL) {
        echo json_encode(['success' => false, 'publication_err' => $publication_err]);
        die();
    } else {
        $sql = "INSERT INTO publication (content,date_publi,user_id_user) VALUES ('{$publication}','{$datetime}','{$id_user}')";
        $db->query($sql);
        echo json_encode(['success' => true]);
    }
    break;
    case 'like':

        $id_publi = $_POST["id_publi"];
        $id_user = $_SESSION["user"]["id_user"];

    $plus = "UPDATE publication SET `like` = `like`+ 1 WHERE idpublication = {$id_publi}";

    $moin = "UPDATE publication SET `like` = `like`- 1 WHERE idpublication = {$id_publi}";

    $count = "SELECT COUNT(*) AS liked FROM `like` WHERE user_id_user = {$id_user} && publication_idpublication= {$id_publi}";

    $insert = " INSERT INTO `like` (user_id_user,publication_idpublication) VALUES ({$id_user},{$id_publi})";

    $delete = "DELETE FROM `like` WHERE `like`.`user_id_user` = {$id_user} AND `like`.`publication_idpublication` = {$id_publi} ";

$res = $db->query($count);
$data = mysqli_fetch_assoc($res);

if ($data['liked'] != 0) {
    if ($db->query($moin)) {
        $db->query($delete);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    if ($db->query($plus)) {
        $db->query($insert);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}
break;
    case'delete':
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
    break;
    case 'comment':
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
    case 'select':

        $req = "SELECT idpublication,content,`like`,date_publi,user_id_user,username,picture_profile,user_id_user FROM `publication` p INNER JOIN `user` u ON p.user_id_user = u.id_user ORDER BY date_publi DESC";

        if ($res = $db->query($req)) {
            echo json_encode(['success' => true, 'result' => resultAsArray($res)]);
        } else {
            echo json_encode(['success' => 'false']);
        }
        default:

        break;
}

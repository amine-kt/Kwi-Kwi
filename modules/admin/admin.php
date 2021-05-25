<?php
session_start();
require_once('../../utils/db_connect.php'); //appel la connexion à la bdd grâce au fichier db_connect.php
require_once('../../utils/function.php');
require('../../flux/vendor/autoload.php');



switch ($_POST['method']) {
    case 'select':
        $sql = "SELECT id_user, firstname, lastname, email, username, created_at, ban FROM `user` WHERE NOT id_user = 1";
        if ($res = $db->query($sql)) {
            echo json_encode(['success' => true, 'result' => resultAsArray($res)]);
        } else {
            echo json_encode(['success' => 'false']);
        }
        break;
    case'ban':
        $ban = "UPDATE `user` SET ban = 1 WHERE id_user = {$_POST['iduser']}";
        if($db->query($ban)){
            echo json_encode(['success'=>true]);
        }else{
            echo json_encode(['success'=> false]);
        }

        break;
        case 'deban':
            $deban = "UPDATE `user` SET ban = 0 WHERE id_user = {$_POST['iduser']}";
            if($db->query($deban)){
                echo json_encode(['success'=>true]);
            }else{
                echo json_encode(['success'=> false]);
            }
            break;
    default:
        # code...
        break;
}

        
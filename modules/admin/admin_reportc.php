<?php

session_start();
require_once('../../utils/db_connect.php'); //appel la connexion à la bdd grâce au fichier db_connect.php
require_once('../../utils/function.php');


        $report = "SELECT idcomment,content,`like`,date_comm,username,picture_profile FROM comment c INNER JOIN `user` u ON c.user_id_user = u.id_user WHERE c.reports >= 1 ORDER BY date_comm DESC";
        if ($res = $db->query($report)) {
            echo json_encode(['success' => true, 'result' => resultAsArray($res)]);
        } else {
            echo json_encode(['success' => 'false']);
        }
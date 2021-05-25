<?php

session_start();
require_once('../../utils/db_connect.php'); //appel la connexion à la bdd grâce au fichier db_connect.php
require_once('../../utils/function.php');


        $report = "SELECT idpublication,content,`like`,date_publi,user_id_user,username,picture_profile,user_id_user FROM `publication` p INNER JOIN `user` u ON p.user_id_user = u.id_user WHERE p.reports >= 1 ORDER BY date_publi DESC";
        if ($res = $db->query($report)) {
            echo json_encode(['success' => true, 'result' => resultAsArray($res)]);
        } else {
            echo json_encode(['success' => 'false']);
        }
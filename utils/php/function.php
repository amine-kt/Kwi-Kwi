<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require('vendor/autoload.php');


function resultAsArray($res)
{ // Prend le résultat d'une requête en paramètre
    $result = array(); // Déclaration d'un tableau vide
    while ($resultRow = mysqli_fetch_assoc($res)) { // Itération sur tous les résultats de la requête
        array_push($result, $resultRow);  // Push de chaque résultat dans le tableau déclaré plus tôt
    }
    return $result; // Retourne le tableau de résultat
}





function smtpMailer($to, $subject, $body)
{
    $mail = new PHPMailer();

    try {
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->Username = "kwikwi.services@gmail.com";
        $mail->Password = "*Azertyuiop9";
        $mail->setFrom("kwikwi.services@gmail.com", 'kwikwi_service');
        $mail->Subject = $subject;
        // $mail->Body = $body;
        $mail->addAddress($to);
        $mail->isHTML(true);
        $mail->CharSet = "utf-8";
        $mail->msgHTML($body);
        $mail->send();

        echo "Message envoyé";
    } catch (Exception $e) {
        echo "Error";
    }
}

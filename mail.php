<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'andredevsec@gmail.com';
        $mail->Password   = 'qgvwhbeqckjokovd';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        $mail->setFrom($_POST["email"], $_POST["name"]);
        $mail->addAddress($_POST["email"]);
        $mail->addReplyTo($_POST["email"], $_POST["name"]);

        $mail->CharSet = 'UTF-8';

        $mail->isHTML(true);
        $mail->Subject = $_POST["subject"];
        $mail->Body    = "Olá, <strong>" . htmlspecialchars($_POST["name"]) . "</strong>!<br><br>" . nl2br(htmlspecialchars($_POST["message"])) . "<br><br>Atenciosamente,<br>André & Josué LTDA.";

        if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
            $mail->addAttachment($_FILES['file']['tmp_name'], $_FILES['file']['name']);
        }

        $mail->send();

        $_SESSION['texto_sucesso'] = 'E-mail enviado com sucesso!';
    } catch (Exception $e) {
        $_SESSION['texto_erro'] = 'Ocorreu um erro ao enviar o e-mail. Detalhes: ' . $mail->ErrorInfo;
    }

    header("Location: contato.php");
    exit();
}
?>

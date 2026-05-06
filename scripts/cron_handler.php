<?php
// Definir que estamos en modo CLI (Command Line Interface)
define('CLI_MODE', true);

require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/libraries/email/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    // Configuración SMTP (puedes traerla de tus constantes de config.php)
    $mail->isSMTP();
    $mail->Host       = SMTP_HOST;            // Specify main and backup SMTP servers
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = SMTP_USERNAME;                     // SMTP username
    $mail->Password   = SMTP_PASSWORD;                               // SMTP password
    $mail->SMTPSecure = SMTP_ENCRYPTION;                                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = SMTP_PORT;                                 // TCP port to connect to
    //Recipients
    $mail->setFrom(MAIL_FROM_ADDRESS, MAIL_FROM_NAME_ORDERS);
    $mail->addAddress(MAIL_ORDERS_TO);
    $mail->isHTML(true);
    $message= "PHPMailer inicializado correctamente en el Cron.";
    $mail->Subject = 'New Email GTW ';
    $mail->Body    = $message;
    $mail->CharSet = 'UTF-8';
    $mail->send();
} catch (Exception $e) {
    echo "Error: {$mail->ErrorInfo}";
}
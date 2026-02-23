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
    $mail->Host       = 'smtp-mail.outlook.com';            // Specify main and backup SMTP servers
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'lifeline@galaxydistribution.com';                     // SMTP username
    $mail->Password   = 'Life@2025$$Galaxy';                               // SMTP password
    $mail->SMTPSecure = 'TLS/StartTLS';                                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = 587;                                 // TCP port to connect to
    //Recipients
    $mail->setFrom('lifeline@galaxydistribution.com', 'Galaxy Lileline Orders');
    $mail->addAddress('xneriox@gmail.com');
    $mail->isHTML(true);
    $message= "PHPMailer inicializado correctamente en el Cron.";
    $mail->Subject = 'New Email GTW ';
    $mail->Body    = $message;
    $mail->CharSet = 'UTF-8';
    $mail->send();
} catch (Exception $e) {
    echo "Error: {$mail->ErrorInfo}";
}
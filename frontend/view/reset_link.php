<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '/xampp/htdocs/frontend/view/PHPmailer/Exception.php';
require '/xampp/htdocs/frontend/view/PHPmailer/PHPMailer.php';
require '/xampp/htdocs/frontend/view/PHPmailer/SMTP.php';

$mail = new PHPMailer(true);

try {
  // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
  $mail->isSMTP();
  $mail->Host = "smtp.gmail.com";
  $mail->SMTPAuth = true;
  $mail->Username = "dire.inf.app@gmail.com";
  $mail->Password = "ewpubayapojhhixv";
  // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
  $mail->Port = 587;

  $mail->setFrom("dire.inf.app@gmail.com");
  $mail->addAddress($email);
  $mail->isHTML(true);
  $mail->Subject = "Recuperacion de Password";
  $mail->Body = "Haz click <a href='http://localhost/frontend/view/reset_contraseña.php?token=$token'>Aqui</a> Para recuperar tu contraseña";

  $mail->send();
  $confirm = "Mensaje enviado, por favor revise su email.";
} catch (Exception $e) {
  echo "El mensaje no pudo ser enviado. Error en el email: {$mail->ErrorInfo}";
}

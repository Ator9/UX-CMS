<?php

/**
 *
 * Example:
 *
 * $mail= new PHPMailer();
 * $mail->ContentType = 'text/html';
 * $mail->CharSet 	   = 'utf-8';
 * $mail->SetFrom($_POST['email'], $_POST['nombre']); // $CONFIG['email'], $CONFIG['sitename']
 * $mail->Sender      = 'info@uxers.com.ar'; // $CONFIG['email']
 * $mail->Subject 	   = 'Contact';
 * $mail->Body 	   = $body;
 * $mail->AddAddress('info@uxers.com.ar');
 * $mail->AddCC('info@uxers.com.ar'); // Copia
 * $mail->AddBCC('info@uxers.com.ar'); // Copia Oculta
 * $mail->AddAttachment('images/phpmailer.gif');
 *
 *
 * // Need STMP?:
 * $mail->IsSMTP();
 * $mail->SMTPAuth = true;
 * $mail->Host	   = SMTP_HOST;
 * $mail->Port     = SMPT_PORT;
 * $mail->Username = SMTP_USER;
 * $mail->Password = SMTP_PASS;
 *
 *
 * $mail->Send();
 *
 */

require(dirname(__FILE__).'/../lib/phpmailer/class.phpmailer.php');


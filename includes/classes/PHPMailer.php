<?php
/**
 * PHPMailer
 *
 * @author Sebastián Gasparri
 * @link https://github.com/Ator9
 * @link https://github.com/PHPMailer/PHPMailer
 *
 * Example:
 * $mail= new PHPMailer();
 * $mail->ContentType = 'text/html';
 * $mail->CharSet 	   = 'utf-8';
 * $mail->SetFrom($_POST['email'], $_POST['nombre']);
 * $mail->Sender      = 'info@uxers.com.ar';
 * $mail->Subject 	   = 'Contact';
 * $mail->Body 	   = $body;
 * $mail->AddAddress('info@uxers.com.ar');
 * $mail->AddCC('info@uxers.com.ar'); // Copia
 * $mail->AddBCC('info@uxers.com.ar'); // Copia Oculta
 * $mail->AddAttachment('image.gif');
 *
 * Need STMP?:
 * $mail->IsSMTP();
 * $mail->SMTPAuth = true;
 * $mail->Host	   = SMTP_HOST;
 * $mail->Port     = SMPT_PORT;
 * $mail->Username = SMTP_USER;
 * $mail->Password = SMTP_PASS;
 *
 * $mail->Send();
 *
 */

require(INCLUDES.'/lib/phpmailer/PHPMailerAutoload.php');

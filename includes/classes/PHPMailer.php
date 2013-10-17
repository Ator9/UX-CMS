<?

/**
 *
 * Ejemplo:
 *
 * $mail= new PHPMailer();
 * $mail->ContentType = 'text/html';
 * $mail->CharSet 	   = 'utf-8';
 * $mail->SetFrom($_POST['email'], $_POST['nombre']); // $CONFIG['email'], $CONFIG['sitename']
 * $mail->Sender      = 'info@hardwarevs.com'; // $CONFIG['email']
 * $mail->Subject 	   = 'Contacto';
 * $mail->Body 	   = $cuerpo;
 * $mail->AddAddress('pcimpacto@fibertel.com.ar');
 * $mail->AddCC('pcimpacto@fibertel.com.ar'); // Copia
 * $mail->AddBCC('pcimpacto@fibertel.com.ar'); // Copia Oculta
 * $mail->AddAttachment('images/phpmailer.gif');
 *
 *
 * // Si necesito STMP (para usar localmente mas que nada):
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
?>

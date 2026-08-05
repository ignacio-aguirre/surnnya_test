<?php
include("funciones.php");
session_start();
?>

</div>

<div class="container">

<?php

if(isset($_GET["mail"]) && isset($_GET["dni"])) {

 $dirmail=$_GET["mail"];
 $dni=nget("dni");
 $id=un_campo("select id from usuarios_hogares where email=".tsql($dirmail)." and dni=".$dni." and baja is null");
 if(!$id>"0"){die("Error USUARIO_NO_ENCONTRADO. Por favor comunicate con Supervisi&oacute;n para solucionarlo.");};
 $reg=un_registro("select  * from usuarios_hogares where id=".$id);

 error_reporting(E_STRICT);
require_once('PHPMailer/class.phpmailer.php');
$mail                = new PHPMailer();
$mail->IsSMTP(); // telling the class to use SMTP
$mail->SMTPTimeOut = 190; 
$mail->SMTPDebug = 0; 
$mail->SMTPSecure      = "tls";                  // enable SMTP authentication
$mail->SMTPAuth      = true;                  // enable SMTP authentication
$mail->SMTPKeepAlive = true;                  // SMTP connection will not close after each email sent
$mail->Host          = "smtppro.zoho.com"; // sets the SMTP server
$mail->Port          = 587;                    // set the SMTP port for the GMAIL server
$mail->Username      = "notificacioncdnnya@undato.com.ar"; // SMTP account username
$mail->Password      = "718Q21_Mi";        // SMTP account password 
$mail->SetFrom('notificacioncdnnya@undato.com.ar', 'Notificaciones CDNNYA');
$mail->AddReplyTo('iaguirre@buenosaires.gob.ar', 'Ignacio Aguirre');
$mail->Subject       = "Trimestrales: Recordatorio de Password";
$mail->MsgHTML("<html>Estimade <strong>".$reg['nombres']." ".$reg['apellidos']."</strong><br>Le recordamos su usuario <strong>".$reg["descripcion"]."<strong><br>
   y su contraseña: <strong>".$reg["password"]."</strong><br><br><br>Mensaje generado autom&aacute;ticamente por Trimestrales</html>");
 $mail->AddAddress($reg['email'], $reg['nombres']." ".$reg['apellidos']);
//$mail->AddAddress('iaguirre@buenosaires.gob.ar', 'Aguirre'." ".'Ignacio');
 if(!$mail->Send()) {    echo "Error (" . str_replace("@", "&#64;", $reg['emailusuario']) . ') ' . $mail->ErrorInfo . '<br />';}
 else {
    echo "Mail enviado a :" .$reg['nombres']." ".$reg['apellidos']. ' (' . str_replace("@", "&#64;", $reg['email']) . ')<br />';
 };
 $mail->ClearAddresses();
 $mail->ClearAttachments();
};
?>


<p align='center'>Haga Click <a href='.'>Aqu&iacute;</a> para Ingresar a Trimestrales</p>
</div>
</body>
</html>


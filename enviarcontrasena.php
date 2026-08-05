<?php
include("Funciones.php");
session_start();

?>

</div>

<div class="container">

<?php

if(isset($_GET["mail"]) && isset($_GET["cuil"])) {

 $dirmail=$_GET["mail"];
 $cuil=$_GET["cuil"];
 $id=un_campo("select id from usuarios where email=".tsql($dirmail)." and cuil=".tsql($cuil)." and baja is null");
 if($id>"0"){
 error_reporting(E_STRICT);
 require 'vendor/autoload.php';
 $mail = new PHPMailer\PHPMailer\PHPMailer(true);
  $mail->IsSMTP(); // telling the class to use SMTP
 $mail->SMTPTimeOut = 190; 
 $mail->SMTPDebug = 0; 
// configuracion 
 $mail->SMTPSecure      = "tls";                  // enable SMTP authentication
 $mail->SMTPAuth      = true;                  // enable SMTP authentication
 $mail->SMTPKeepAlive = true;                  // SMTP connection will not close after each email sent
 $mail->Host          = "smtppro.zoho.com"; // sets the SMTP server
 $mail->Port          = 587;                    // set the SMTP port for the GMAIL server
 $mail->Username      = "notificacioncdnnya@undato.com.ar"; // SMTP account username
 $mail->Password      = "718Q21_Mi";        // SMTP account password 
 $mail->SetFrom('notificacioncdnnya@undato.com.ar', 'Notificaciones CDNNYA');
 $mail->AddReplyTo('iaguirre@buenosaires.gob.ar', 'Ignacio Aguirre');
 $mail->Subject       = "SURNNYA: Recordatorio de Password";

 $reg=un_registro("select  * from usuarios where id=".$id);
 if($reg["id"]>"0"){
  //$mail->AltBody    = "Mensaje de Prueba"; 
  $mail->MsgHTML("<html>Estimado/a <strong>".$reg['nombre']." ".$reg['apellido']."</strong><br>Le informamos su nueva contraseña: <strong>".$reg["password"]."</strong><br><br><br>Mensaje generado autom&aacute;ticamente por SURNNYA</html>");
  $mail->AddAddress($reg['email'], $reg['nombre']." ".$reg['apellido']);
  $mensaje="";
  if(!$mail->Send()) {

    $mensaje="Error (" . str_replace("@", "&#64;", $reg['email']) . ') ' . $mail->ErrorInfo . '<br />';

  } else {

    $mensaje="Mail enviado a :" .$reg['nombre']." ".$reg['apellido']. ' (' . $reg['email'] . ')';
    ejecute("update usuarios set intentos=4 where id=".$reg["id"]);
  };
 };
  // Clear all addresses and attachments for next loop

  $mail->ClearAddresses();

  $mail->ClearAttachments();
} else{$mensaje="Error en el envio de contrase&ntilde;a";};
} else{
$mensaje="No encontrado";
};
$url="salir?mensaje=".$mensaje;
Redirect($url);
?>

</div>
</body>

</html>


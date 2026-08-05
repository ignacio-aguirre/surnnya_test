<?php
include("funciones.php");
session_start();
include("static/par-conexion.php");
$_SESSION['gldispo']="fake";
$_SESSION['glidusua']=0;
$_SESSION['glusua']="sin password";
$_SESSION['menu']="Salir";
$_SESSION["prestacion"]="Restauraci&oacute;n de contrase&ntilde;a";
//include("encabezado.php");
?>
</div>

<div class="container">

<?php

if(isset($_GET["mail"]) && isset($_GET["cuil"])) {

 $dirmail=$_GET["mail"];
 $cuil=$_GET["cuil"];
 $id=un_campo("select idusuarios from usuarios where email=".tsql($dirmail)." and cuil=".tsql($cuil)." and baja is null");
 if($id>"0"){
 error_reporting(E_STRICT);
 require '../vendor/autoload.php';
 $mail = new PHPMailer\PHPMailer\PHPMailer(true);
 
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
  $mail->Subject       = "DEPOSITO: Envio de Password";
  $reg=un_registro("select  * from usuarios where idusuarios=".$id);
  if($reg["idusuarios"]>"0"){
  $mail->MsgHTML("<html>Estimade <strong>".$reg['nombre']." ".$reg['apellido']."</strong><br>Le informamos su nueva contraseña: <strong>".$reg["password"]."</strong><br><br><br>Mensaje generado autom&aacute;ticamente por Sistema Depósito</html>");

  $mail->AddAddress($reg['email'], $reg['nombre']." ".$reg['apellido']);

  if(!$mail->Send()) {

    echo "Error (" . str_replace("@", "&#64;", $reg['email']) . ') ' . $mail->ErrorInfo . '<br />';

  } else {

    echo "Mail enviado a :" .$reg['nombre']." ".$reg['apellido']. ' (' . str_replace("@", "&#64;", $reg['email']) . ')<br />';
  };
 };
  // Clear all addresses and attachments for next loop

  $mail->ClearAddresses();

  $mail->ClearAttachments();
} else{die("error");};
} else{
die("No encontrado");
};
?>


<p align='center'>

Haga Click <a href='.'>Aqu&iacute;</a> para Ingresar al sistema (cuando recuerde la contrase&ntilde;a)

</p>

</div>
</body>

</html>


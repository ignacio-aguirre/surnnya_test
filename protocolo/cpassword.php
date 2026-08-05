<?php
include('funciones.php');
session_start();

$id=$_GET["id"];
$password=$_GET["pass"];
$pass="'".password_hash($_GET["pass"],PASSWORD_DEFAULT)."'";
$salir="0";
if(isset($_GET["salir"])) $salir="1";
ejecute("update usuarios set password=".$pass." where idusuarios=".$id);
enviapassword($id,$password);
Redirect(si($salir=="0","menu","salir"));

function enviapassword($id,$password){
error_reporting(E_STRICT);
 require '../vendor/autoload.php';
$mail = new PHPMailer\PHPMailer\PHPMailer(true);

  
  $body                = "";
  $mail->IsSMTP(); // telling the class to use SMTP
  $mail->SMTPTimeOut = 260; 
  $mail->SMTPDebug = 0; 
 $mail->SMTPSecure      = "tls";                  // enable SMTP authentication
 $mail->SMTPAuth      = true;                  // enable SMTP authentication
 $mail->SMTPKeepAlive = true;                  // SMTP connection will not close after each email sent
 $mail->Host          = "smtppro.zoho.com"; // sets the SMTP server
 $mail->Port          = 587;                    // set the SMTP port for the GMAIL server
 $mail->Username      = "notificacioncdnnya@undato.com.ar"; // SMTP account username
 $mail->Password      = "718Q21_Mi";        // SMTP account password 
 $mail->SetFrom('notificacioncdnnya@undato.com.ar', 'Notificaciones CDNNYA - undato.com.ar');
  $mail->Subject       = "SDC undato.ar: Cambio de Password";
  $reg=un_registro("select  * from usuarios where idusuarios=".$id);
  $mail->MsgHTML("<html>Estimad@ <strong>".$reg['nombres']." ".$reg['apellidos']."</strong><br>Le informamos su nueva contraseña de acceso al Sistema de Datos Compartidos: <strong>".$password."</strong><br><br>Mensaje generado autom&aacute;ticamente por www.undato.com.ar</html>");
  $mail->AddAddress($reg['email'], $reg['nombres']." ".$reg['apellidos']);
  if(!$mail->Send()) {
    echo "Error (" . str_replace("@", "&#64;", $reg['email']) . ') ' . $mail->ErrorInfo . '<br />';
  } else {
    echo "Mail enviado a :" .$reg['nombres']." ".$reg['apellidos']. ' (' . str_replace("@", "&#64;", substr($reg['email'],0,6)."...") . ')<br />';
    echo "Si no llega el mensaje a su bandeja de entrada por favor revise en la de correo no deseado<br>";
  };
  // Clear all addresses and attachments for next loop
  $mail->ClearAddresses();
  $mail->ClearAttachments();
return true; 
}
?>
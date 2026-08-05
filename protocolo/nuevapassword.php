<?php
include("funciones.php");
session_start();?>
<html lang="es">
<head>
<title>Blanqueo de Password</title>
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<link rel="stylesheet" href="../bootstrap-3.3.6-dist/css/bootstrap.min.css">
</head>
<body>
<?php
if(isset($_SESSION["usuario"])) { 
 $id=$_SESSION["usuario"];
 $nuevapassword=generaPass($id);

 $pass="'".password_hash($nuevapassword,PASSWORD_DEFAULT)."'";
 ejecute("update usuarios set  intentos=0, password=".$pass." where idusuarios=".$id);

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
  $mail->Subject       = "SDC undato.ar: Blanqueo de Contraseña";
  $reg=un_registro("select  * from usuarios where idusuarios=".$id);
  $mail->MsgHTML("<html>Estimad@ <strong>".$reg['nombres']." ".$reg['apellidos']."</strong><br>Le informamos su nueva contraseña provisoria: <strong>".$nuevapassword."</strong><br>Una vez logrado el primer ingreso, deberá cambiarla<br><br><br>Mensaje generado autom&aacute;ticamente por www.undato.com.ar</html>");
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
  //session_destroy();
};
  //session_destroy();
function generaPass($id){
  return "emergencia!";
}
?>

Haga Click <a href='about:blank'>Aqu&iacute;</a> para salir.
<!--script src="bootstrap-3.3.6-dist/js/jquery.js"></script>
<script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
<script src="js/generales.js"></script-->
</body>
</html>


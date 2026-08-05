<?php
session_start();
include("funciones.php");
$dispositivo=nget("dispositivo");
$apellidos=tget("apellidos");
$nombres=tget("nombres");
$email=tget("email");
$acronimo=tget("acronimo");
$password=contrasenia_aleat(); 
$id=inserte("insert into movil_usuarios(apellidos,nombres,email,acronimo,password,f_autenticado,dispositivo) values(".
	$apellidos.",".
	$nombres.",".
	$email.",".
	$acronimo.",".
	$password.", curdate(), ".
    $dispositivo.")");
	envia_provisoria($id);
Redirect("mv_usuarios_do?dispositivo=".$dispositivo);
function contrasenia_aleat(){
  //prefijo=numero
  $pre=(string) rand(1009,9836);
  
  $letras="ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  $especiales="#$.-!";
  
  $i=rand(1,strlen($letras)-2);
  $l1=substr($letras,$i,2);
  $i=rand(1,strlen($letras)-1);
  $l2=strtolower(substr($letras,$i,1));
  $i=rand(1,strlen($especiales));
  $especial=substr($especiales,$i,1);
  
  return tsql($pre. $especial.$l1.$l2);
  
}

function envia_provisoria($id){
    $r=un_registro("select * from movil_usuarios where id=".$id);
    $d=un_campo("select nombre from dispositivos where id=".$r["dispositivo"]);
    error_reporting(E_STRICT);
     require '../vendor/autoload.php';
     $mail = new PHPMailer\PHPMailer\PHPMailer(true);
     $mail->IsSMTP(); // telling the class to use SMTP
     $mail->SMTPTimeOut = 260; 
     $mail->SMTPDebug = 0; 
     $mail->SMTPSecure    = "tls";                // enable SMTP authentication
     $mail->SMTPAuth      = true;                  // enable SMTP authentication
     $mail->SMTPKeepAlive = true;                  // SMTP connection will not close after each email sent
     $mail->Host          = "smtppro.zoho.com";// sets the SMTP server
     $mail->Port          = 587;                    // set the SMTP port for the GMAIL server
     $mail->Username      = "notificacioncdnnya@undato.com.ar"; // SMTP account username
     $mail->Password      = "718Q21_Mi";
     $mail->SetFrom('notificacioncdnnya@undato.com.ar', 'Notificaciones CDNNYA');
     $mail->AddReplyTo('iaguirre@buenosaires.gob.ar', 'Ignacio Aguirre');
     $mail->Subject       = "Usuario de modulo Moviles";
     $mail->MsgHTML("<html>Se ha creado un usuario de Moviles asociado a su cuenta de mail. y al dispositivo ".$d."<br>
      Usuario: <strong>".$r["acronimo"]."</strong><br>
 La contrase&ntilde;a provisoria es <strong>".$r["password"]."</strong><br>
 </html>");
     $mail->AddAddress($r["email"], $r["apellidos"]." ".$r["nombres"]);
     if(!$mail->Send()) {
       $mail->ClearAddresses();
       $mail->ClearAttachments();
       return false;
     } 
     
     $mail->ClearAddresses();
     $mail->ClearAttachments();
     return true;
}



?>
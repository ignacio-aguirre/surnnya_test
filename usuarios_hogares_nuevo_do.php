<?php
session_start();
include("Funciones.php");
srand (time());

$hogar=$_GET["hogar"];
$apellidos=tget("apellidos");
$nombres=tget("nombres");
$dni=nget("dni");
$exis=un_campo("select id from usuarios_hogares where dni=".$dni." and baja is null");
if($exis>0){die("Usuario existente");};
$profesion=tget("profesion");
$matricula=tget("matricula");
$email=tget("email");
$firma=si($_GET["firma"]=="on","1","0");
$es_trimestrales="1";
$perfil_moviles=nget("perfil_moviles");
$descripcion=tget("descripcion");
$es_multihogar=si($_GET["es_multihogar"]=="on","1","0");
$password=contrasenia_aleat(); 

$id=inserte("insert into usuarios_hogares(apellidos,nombres,dni,profesion,matricula,email,firma,descripcion,password,es_multihogar,hogar,perfil_moviles) values(".
$apellidos.",".$nombres.",".$dni.",".$profesion.",".$matricula.",".$email.",".$firma.",".$descripcion.",".$password.",".$es_multihogar.",".$hogar.",".$perfil_moviles.")");
ejecute("update usuarios_hogares set apellidos=".$apellidos.",nombres=".$nombres.", dni=".$dni.", profesion=".$profesion.", matricula=".$matricula." where id=".$id);
ejecute("update usuarios_hogares set email=".$email.",es_trimestrales=".$es_trimestrales.",firma=".$firma.", descripcion=".$descripcion.", password=".$password.", es_multihogar=".$es_multihogar.", f_autenticado=curdate()
, perfil_moviles=".$perfil_moviles." where id=".$id);
envia_provisoria($id);
if($es_multihogar=="1"){
  ejecute("update usuarios_hogares set funcion=null, hogar=0 where id=".$id);
  Redirect("usuarios_hogares_multihogar?id=".$id);
 } 
else{
  Redirect("usuarios_hogares_hogar?id=".$id."&hogar=".$hogar);
}

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
    $r=un_registro("select * from usuarios_hogares where id=".$id);
    error_reporting(E_STRICT);
     require 'vendor/autoload.php';
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
     $mail->Subject       = "Usuario de Trimestrales creado DNI".$r["dni"];
     $mail->MsgHTML("<html>Se ha creado un usuario Trimestrales asociado al dni del asunto y su cuenta de mail.<br>
      Usuario: <strong>".$r["descripcion"]."</strong><br>
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
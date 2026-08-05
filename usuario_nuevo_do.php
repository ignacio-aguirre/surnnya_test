<?php
session_start();
include("Funciones.php");

srand (time());
$cuil=tpost("cuil");
$exis=un_campo("select id from usuarios where cuil=".$cuil);
if($exis>0){die("Usuario existente");};
$apellido=tpost("apellido");
$nombre=tpost("nombre");
$email=tpost("email");
$tipo_usuario=tpost("tipo_usuario");
if(isset($_POST["sector"])){$sector=npost("sector");}
else{$sector="0";};
if(isset($_POST["perfil"])){$perfil=npost("perfil");}
else{$perfil="0";};
if(isset($_POST["dispositivo"])){$dispositivo=npost("dispositivo");}
else{$dispositivo="0";};
$password=contrasenia_aleat(); 
$id=inserte("insert into usuarios(apellido,nombre,email,password,sector,perfil,cuil,pwcambio,intentos,estado,tipo_usuario,dispositivo) values(".
$apellido.",".$nombre.",".$email.",".$password.",".$sector.
",".$perfil.",".$cuil.",curdate(),0,'ACTIVO',".$tipo_usuario.",".$dispositivo.")");
envia_provisoria($id);
Redirect("usuarios");
function envia_provisoria($id){
    $r=un_registro("select * from usuarios where id=".$id);
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
     $mail->Subject       = "Usuario de SURNNYA creado ".$r["cuil"];
     $mail->MsgHTML("<html>Se ha creado un usuario SURNNYA asociado al cuil del asunto y su cuenta de mail.<br>
 La contraseña provisoria es <strong>".$r["password"]."</strong><br>
 El agente del CDNNYA usuario de SURNNYA (en adelante el Agente) conoce y acepta que será exclusivamente responsable de adoptar todas las medidas de seguridad para proteger el cuil y la contraseña de su cuenta de usuario (en adelante la Cuenta) en el marco del uso del sistema SURNNYA. El Agente conoce y acepta que su Cuenta es privada, secreta e intransferible. El resguardo de la Cuenta será responsabilidad exclusiva del Agente.
<br>El Agente declara conocer que los datos e información que toma conocimiento en el desarrollo de su tarea se encuentran amparados bajo normas de confidencialidad. Queda prohibida la divulgación de toda información sensible. 
El uso del sistema SURNNYA accedido mediante la Cuenta, será considerado como válido, legítimo y auténticamente realizado por el Agente, asumiendo este último las consecuencias del uso de la misma en su nombre.
<br>El Agente se compromete a guardar la máxima reserva y secreto sobre los datos e información a que acceda en virtud de las funciones encomendadas, a utilizar dicha información solamente para el fin específico al que se la ha destinado, a no comunicar o hacer pública la información no clasificada como “pública”, y a observar y adoptar cuantas medidas de seguridad sean necesarias para asegurar la confidencialidad, secreto e integridad de los datos e información, salvo autorización legal o instrucción expresa de la autoridad competente.
</html>");
     $mail->AddAddress($r["email"], $r["cuil"]);
     if(!$mail->Send()) {
       echo "<br>Error enviando contraseña provisoria por mail<br>";
     } else {
       echo "<br>Contraseña provisoria enviada por mail<br>";
      };
     // Clear all addresses and attachments for next loop
     $mail->ClearAddresses();
     $mail->ClearAttachments();
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

?>
<?php
session_start();
include("Funciones.php");
  error_reporting(E_STRICT);
  require 'vendor/autoload.php';
 $mail = new PHPMailer\PHPMailer\PHPMailer(true);
$body                = cuerpo();
  $mail->IsSMTP(); // telling the class to use SMTP
  $mail->SMTPTimeOut = 260; 
  $mail->SMTPDebug = 0; 
 $mail->SMTPSecure      = "tls";                  
 $mail->SMTPAuth      = true;                 
 $mail->SMTPKeepAlive = true;                 
 $mail->Host          = "smtppro.zoho.com"; 
 $mail->Port          = 587;                
 $mail->Username      = "notificacioncdnnya@undato.com.ar"; // SMTP account username
 $mail->Password      = "718Q21_Mi";        
 $mail->SetFrom('notificacioncdnnya@undato.com.ar', 'Notificaciones CDNNYA');
 $mail->AddReplyTo('iaguirre@buenosaires.gob.ar', 'Ignacio Aguirre');
  $mail->Subject       = "Monitoreos ".$_SESSION["DiaHoy"];
  $mail->MsgHTML($body);
  $mail->AddAddress("aarispe@buenosaires.gob.ar", "Agustin Arispe");
  
  $mail->Send();
  // Clear all addresses and attachments for next loop
  $mail->ClearAddresses();
  $mail->ClearAttachments();
ejecute("update procesos set ultimaejecucion=curdate() where proc_url='monitoreo_alerta'");
Redirect($_SESSION["menu"]."?id=1");

function cuerpo(){
/* por ahora harcodeo las ut, modificar luego */
$s="<h2>Monitoreos a Realizar</h2><table>";
$s=$s."<tr><td>Dispositivo</td><td>Responsable Monitoreo</td><td>&Uacute;ltimo Monitoreo</td><td>Frecuencia</td></tr>";
$sql="SELECT dispositivos.nombre, concat(usuarios.apellido,', ',usuarios.nombre) as apynom, ultimo_monitoreo, frecuencia
FROM `dispositivos` 
left join usuarios on usuario_monitoreo=usuarios.id
WHERE frecuencia>0 and dispositivos.baja is null and (ultimo_monitoreo is not null and datediff(curdate(),ultimo_monitoreo)/31>frecuencia or ultimo_monitoreo is null) order by ultimo_monitoreo";
$reg=registros($sql);
while($r=mysqli_fetch_assoc($reg)){
$s=$s."<tr><td>".utf8_decode($r["nombre"])."</td><td>".$r["apynom"]."</td><td>".ffec($r["ultimo_monitoreo"])."</td><td>".$r["frecuencia"]."</td></tr>";
};
return $s."</table>";
}
?>
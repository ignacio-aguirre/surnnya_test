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
  $mail->Subject       = "Alojados ".$_SESSION["DiaHoy"];
  $mail->MsgHTML($body);
  $mail->AddAddress("msabanorsini@buenosaires.gob.ar", "Micaela Saban Orsini"); 
  $mail->AddAddress("gillanes@buenosaires.gob.ar", "Guillermo Illanes"); 
  $mail->AddAddress("cjalave@buenosaires.gob.ar", "Vanesa Jalave"); 
  $mail->AddAddress("ppatino@buenosaires.gob.ar", "Paula Patinho");
  $mail->AddAddress("mpeyrou@buenosaires.gob.ar", "Mariana Peyrou");
  $mail->AddAddress("iaguirre@buenosaires.gob.ar", "Ignacio Aguirre"); 
  $mail->Send();
  // Clear all addresses and attachments for next loop
  $mail->ClearAddresses();
  $mail->ClearAttachments();
ejecute("update procesos set ultimaejecucion=curdate() where proc_url='alojados_enviar'");
Redirect($_SESSION["menu"]."?id=1");

function cuerpo(){
$sql="select case when ong>0 then 'CONVENIADOS' else 'PROPIOS' end as deno , 
   sum(case when direccion_operativa=1 then 1 else 0 end) as cdovs,sum(case when direccion_operativa=2 then 1 else 0 end) as cdoie, count(*) as cantidad
    from hogares_admision
    left join sujetos on admi_legajo=sujetos.legajo
    left join dispositivos on admi_hogar=dispositivos.id
    where area_gubernamental=1 and admi_alta <=curdate() and (admi_baja is null or admi_baja>curdate()) group by deno order by deno";
$s="<h4>Alojados en Dispositivos DGSAP</h4><table><tr><th>Pertenencia</th><th>DOAAVS</th><th>DOAIVS</th><th>Total</th></tr>";
$t=0;
$doavs=0;
$doie=0;
$reg=registros($sql); 
while($r=mysqli_fetch_assoc($reg)){
 $s=$s."<tr><td>".$r["deno"]."</td><td align='center'>".$r["cdovs"]."</td><td align='center'>".$r["cdoie"]."</td><td align='center'>".$r["cantidad"]."</td></tr>";
 $t=$t+$r["cantidad"];
 $doavs=$doavs+$r["cdovs"];
 $doie=$doie+$r["cdoie"];
};
$s=$s."<tr><td>Total</td><td align='center'>".$doavs."</td><td align='center'>".$doie."</td><td align='center'>".$t."</td></tr>";
$s=$s."</table><h4>Vacantes a Asignar</h4><table>";
$regi=registros("select deno,count(*) as c from hogares_admision left join tablas on admi_cate=tablas.valo and tablas.tipo='ADCAT' where admi_susp is null and admi_alta is null  
and admi_fderiv is null group by  deno
union all select 'TOTAL' as deno, count(*) from hogares_admision where admi_susp is null and admi_alta is null  and admi_fderiv is null order by deno");
while($reg=mysqli_fetch_assoc($regi)){
 $s=$s."<tr><td>";
 $s=$s.$reg["deno"];
 $s=$s."</td><td>".$reg["c"]."</td></tr>";
};
$s=$s."</table>";
$s=$s."</table><h4>Vacantes a Asignar por Situaci&oacute;n Socio Habitacional</h4><table>";
$regi=registros("select deno,count(*) as c from hogares_admision left join tablas on admi_proc=tablas.valo and tablas.tipo='HOSSH' where admi_susp is null and admi_alta is null  
and admi_fderiv is null group by  deno
union all select 'ZTOTAL' as deno, count(*) from hogares_admision where admi_susp is null and admi_alta is null  and admi_fderiv is null order by deno");
while($reg=mysqli_fetch_assoc($regi)){
 $s=$s."<tr><td>";
 $s=$s.utf8_decode(si($reg["deno"]=="ZTOTAL","TOTAL",$reg["deno"]))."</td><td>";
 $s=$s."</td><td>".$reg["c"]."</td></tr>";
};
$s=$s."</table>";
$s=$s."<h4>".un_campo("select count(*) from hogares_admision where admi_fderiv is not null and admi_alta is null and admi_susp is null ")." Vacantes Asignadas sin Ingreso del NNYA</h4>";
return $s;
}
?>
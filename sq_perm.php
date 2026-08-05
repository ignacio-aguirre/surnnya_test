<?php
include("Funciones.php"); 
session_start();
$tipo=$_GET["tipo"];
if($tipo=="1"){
 $legajo=$_GET["legajo"];
 ejecute("update hogares_admision set permanencia_total=permanencia where admi_legajo=".$legajo);
};

if($tipo=="2"){
 $legajo=$_GET["legajo"];
 $reg=registros("select idhogares_admision, admi_alta, admi_baja from hogares_admision where admi_alta is not null and admi_legajo=".$legajo." order by admi_legajo, admi_alta,idhogares_admision");
 $baja="null";
 while($r=mysqli_fetch_assoc($reg)){
   ejecute("update hogares_admision set baja_anterior=".$baja." where idhogares_admision=".$r["idhogares_admision"]);
   $baja=fsql(ffec($r["admi_baja"]));
 };

 $reg=registros("select idhogares_admision, admi_legajo, admi_alta, admi_baja, case when baja_anterior is null then 0 else case when datediff(admi_alta,baja_anterior)<366 then 1 else 0 end end as sumar,permanencia from hogares_admision where admi_alta is not null and admi_legajo=".$legajo." order by admi_legajo, admi_alta,idhogares_admision");
 $anterior=0;
 while($r=mysqli_fetch_assoc($reg)){
  if($r["sumar"]==0) {$anterior=0;};
  ejecute("update hogares_admision set perm_anterior=".(string)$anterior.", permanencia_total=".(string)$anterior."+permanencia where idhogares_admision=".$r["idhogares_admision"]);
  $anterior=$anterior+$r["permanencia"];
 };
};
?>
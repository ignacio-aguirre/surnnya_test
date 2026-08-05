<?php
session_start();
include("Funciones.php");
$dispositivo=nget("dispositivo");
$fecha=str_replace("-","",$_GET["fecha"]);
$agentes=tget("agentes");
$existe=un_campo("select count(*) from monitoreos where fecha=".$fecha." and dispositivo=".$dispositivo);
if($existe=="0"){
inserte("insert into monitoreos(dispositivo,fecha,agentes) values(".$dispositivo.",".$fecha.",".$agentes.")");
};
Redirect("monitoreo_nuevo");
?>

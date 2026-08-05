<?php
include("Funciones.php");
session_start();
$id=$_GET["id"];
$estado_ant=un_registro("select * from ad_pedidos_estados where vacante=".$id." order by fecha desc, id desc limit 1");
$estado_anterior=nulea($estado_ant["estado"]);
$estado=$_GET["estado"];
$hogar_anterior=$estado_ant["hogar"];
if($hogar_anterior==""){$hogar_anterior="0";};
$hogar=$_GET["hogar"];
if($hogar==""){$hogar="0";};

if($hogar!=$hogar_anterior || $estado!=$estado_anterior){
  $motivo_cambio=tget("motivo_cambio");
  $fecha=fget("fecha");
  ejecute("update ad_pedidos_estados set motivo_cambio=".$motivo_cambio." where id=".nulea($estado_ant["id"]));
  inserte("insert into ad_pedidos_estados (fecha, vacante, estado, usuario, hogar) values(".$fecha.",".$id.",".nulea($estado).",".tsql($_SESSION["glusua"]).",".nulea($hogar).")");
  ejecute("update hogares_admision set etapa=".$estado.", fecha_etapa=".$fecha.", admi_hogar=".$hogar." where idhogares_admision=".$id);
}
else {die("sin cambios");};

Redirect("admicons");
?>
<?php 
include("Funciones.php"); 
session_start();
$tipo=$_GET["tipo"];
if($tipo=="1"){
  $legajo=nget("legajo");
  /*controla que no haya un alojamiento sin baja */
  $cant = un_campo("select count(*) as cant from hogares_admision where admi_legajo=".$legajo." and admi_alta is not null and admi_baja is null");
  echo $cant;
};
if($tipo=="2"){
  $legajo=nget("legajo");
  /*devuelve la última baja */
  $fecha = ffec(un_campo("select admi_baja from hogares_admision where admi_legajo=".$legajo." and admi_alta is not null order by admi_baja desc, idhogares_admision desc limit 1"));
  echo $fecha;
};
?>
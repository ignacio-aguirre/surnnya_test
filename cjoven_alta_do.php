<?php
include("Funciones.php");
session_start();
$legajo=nget("legajo");
$alta=fget("fecha");
$cantidad=un_campo("select count(*) from cjoven_nomina where legajo=".$legajo." and (baja is null or ".$alta." between alta and baja)");
if($cantidad>"0") die("fecha dentro de otro período de alojamiento");
inserte("insert into cjoven_nomina(legajo,alta) values(".$legajo.",".$alta.")");
Redirect("cjoven_nomina");
?>
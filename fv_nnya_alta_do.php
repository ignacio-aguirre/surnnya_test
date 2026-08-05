<?php
include("Funciones.php");
session_start();
noconsulta();
$familia=$_GET["familia"];
$legajo=nget("legajo");
$fecha_alta=fget("fecha_alta");
if($fecha_alta>fsql($_SESSION["DiaHoy"])){die("La fecha de alta no puede ser futura");};
if($familia!="" && $legajo!=""){
 $id=un_campo("select idfv_familias_miembros from fv_familias_miembros where familia=".$familia." and legajo=".$legajo);
 if(!$id>"0"){ inserte("insert into fv_familias_miembros(familia,legajo,fecha_alta) values(".$familia.",".$legajo.",".$fecha_alta.")");};
};
Redirect("fv_familias_miembros?id=".$familia);
?>
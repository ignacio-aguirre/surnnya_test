<?php
session_start();
include("Funciones.php");
$fecha=dget("fecha");
$hora=tget("hora");
$profesional=nget("profesional");
$nombre=un_campo("select concat(apellido,', ',nombre) from es_profesionales where id=".$profesional);
$legajo=nget("legajo");
$hay=un_campo("select id from es_acciones where profesional=".$profesional." and fecha=".$fecha." and hora=".$hora);
if($hay>0) {echo $nombre."<br>";};
$hay="";
if($legajo>0){$hay=un_campo("select id from es_acciones where legajo=".$legajo." and fecha=".$fecha." and hora=".$hora);
if($hay>0) {echo "NNYA<br>";};
};
exit;

function dget($nombre) {
$fecha=$_GET[$nombre];
if($fecha=="") return "null";
return substr($fecha,0,4).substr($fecha,5,2).substr($fecha,8,2);
}
?>
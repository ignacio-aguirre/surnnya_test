<?php
include("funciones.php"); 
session_start();
$t=tget("t");
$tipo_dispositivo=$_GET["tdispo"];
$dispositivo=nget("dispo");
$cnt=un_campo("select count(*) from movil_domicilios where ".si($tipo_dispositivo=="d","dispositivo","sector")."=".$dispositivo." and domicilio=".$t);
echo $cnt;
exit();
?>
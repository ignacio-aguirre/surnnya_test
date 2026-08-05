<?php
session_start();
include("funciones.php"); 
$calle=tget("calle");
$altura=nget("altura");
$localidad=tget("localidad");

$cnt=un_campo("select count(*) from domicilios where calle=".$calle." and altura=".$altura." and localidad=".$localidad);
echo $cnt;
exit();
?>
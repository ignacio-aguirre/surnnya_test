<?php
session_start();
include("funciones.php"); 
$t=tget("t");
$te=tsql(estandariza_dom($_GET["t"]));

$cnt=un_campo("select count(*) from domicilios where direccion=".$te);
if($cnt=="0"){
	$cnt=un_campo("select count(*) from domicilios where direccion=".$t." and normalizada=0");
};
echo $cnt;
exit();
?>
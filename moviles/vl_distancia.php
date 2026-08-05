<?php
session_start();
include("funciones.php");
$punto_desde=tget("pd");
$punto_hasta=tget("ph");
$km=un_campo("select km from movil_distancias where punto_desde=".$punto_desde." and punto_hasta=".$punto_hasta);
if($km==""){
	$km=un_campo("select km from movil_distancias where punto_desde=".$punto_hasta." and punto_hasta=".$punto_desde);
}
echo $km;
?>
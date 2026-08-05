<?php
session_start();
include("funciones.php");
$punto_desde=tget("pd");
$punto_hasta=tget("ph");
$km=nget("km");
$id=un_campo("select id from movil_distancias where punto_desde=".$punto_desde." and punto_hasta=".$punto_hasta);
if(!$id>"0"){
	inserte("insert into movil_distancias(punto_desde,punto_hasta,km) values(".$punto_desde.",".$punto_hasta.",".$km.")");
}
else{
	ejecute("update movil_distancias set km=".$km." where id=".$id);
}
?>
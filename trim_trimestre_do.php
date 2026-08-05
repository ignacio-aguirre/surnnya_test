<?php
include("Funciones.php");
session_start();
$anio=nget("anio");
$trimestre=nget("trimestre");
$carga_desde=fget("carga_desde");
$carga_hasta=fget("carga_hasta");
ejecute("update parametros set trimestre=".$trimestre.", trimestre_anio=".$anio.", carga_desde=".$carga_desde.",carga_hasta=".$carga_hasta);
Redirect($_SESSION["menu"]);
?>
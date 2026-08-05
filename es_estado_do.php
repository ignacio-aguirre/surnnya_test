<?php
include("Funciones.php");
session_start();
$id=nget("solicitud");
$estado=$_GET["estado"];
$fecha_estado=fget("fecha_estado");
$motivo_estado=tget("motivo_estado");
if($estado=="np"){$campo_fecha="fecha_rechazo";};
if($estado=="cr"){$campo_fecha="fecha_fin";};
ejecute("update es_participaciones set ".$campo_fecha."=".$fecha_estado.", motivo_estado=".$motivo_estado." where id=".$id);
Redirect($_SESSION["menu"]);
?>
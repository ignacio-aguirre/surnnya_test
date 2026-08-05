<?php
include("Funciones.php");
session_start();
$id=nget("id");
$nombre_reporte=tget("nombre_reporte");
$nombre_menu=tget("nombre_menu");
$url_principal=tget("url_principal");
$excel=nget("excel");
$definicion_operativa=tget("definicion_operativa");
if($id=="0"){$id=inserte("insert into reportes (nombre_reporte) values(".$nombre_reporte.")");};
ejecute("update reportes set nombre_reporte=".$nombre_reporte.", nombre_menu=".$nombre_menu.", url_principal=".$url_principal.", excel=".$excel.
", definicion_operativa=".$definicion_operativa." where id=".$id);
Redirect("reportes");
?>

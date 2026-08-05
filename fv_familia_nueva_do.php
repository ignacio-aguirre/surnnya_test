<?php
include("Funciones.php");
$descripcion=tsql($_POST["descripcion"]);
$legajomanual=intval($_POST["legajomanual"]);
$localidad=intval($_POST["localidad"]);
$domicilio=tsql($_POST["domicilio"]);
$id=inserte("insert into fv_familias(descripcion,legajomanual,localidad,domicilio) 
 values(".$descripcion.",".$legajomanual.",".$localidad.",".$domicilio.")");
Redirect("fv_familias_miembros?id=".$id);
?>

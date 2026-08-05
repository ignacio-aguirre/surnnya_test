<?php
include("Funciones.php");
$id=$_POST["id"];
$descripcion=tsql($_POST["descripcion"]);
$legajomanual=intval($_POST["legajomanual"]);
$localidad=intval($_POST["localidad"]);
$domicilio=tsql($_POST["domicilio"]);
ejecute("update fv_familias set descripcion=".$descripcion.",legajomanual=".
 $legajomanual.",localidad=".$localidad.",domicilio=".$domicilio." where idfv_familias=".$id); 
Redirect(si($_POST["ret"]=="1","fv_familias","fv_familias_general"));
?>

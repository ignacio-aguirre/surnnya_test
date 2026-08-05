<?php
include("Funciones.php");
session_start();
$lega=$_GET["legajo"];
$arch=un_campo("select max(archivo) from sujetos_medidas where legajo=".$lega);
$da=un_registro("select * from archivos_subidos where idarchivos_subidos=".$arch);
echo "<a href='descarga?link=".sacamas($da['as_path'])."&nombre=".sacamas_limpia(sacapath($da['as_path']))."'>Descargar Medida</a>";
?>

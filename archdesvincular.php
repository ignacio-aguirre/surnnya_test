<?php
include("Funciones.php"); 
session_start();
$id=$_GET["id"];
$tipo=$_GET["tipo"];
$identificador=$_GET["identificador"];
ejecute("delete from archivos_vinculos where archivo=".$id." and tipo='".$tipo."' and identificador=".$identificador);
Redirect($_SERVER["HTTP_REFERER"]);
?>

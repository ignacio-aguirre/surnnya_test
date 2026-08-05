<?php
require("funciones.php"); 
session_start();
include("encabezado.php");
$id=nget("id");
ejecute("delete from movil_domicilios where id=".$id);
$_SESSION["msg"]="Domicilio #".$id." eliminado";
Redirect("mv_domicilios");
?>

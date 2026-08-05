<?php
session_start(); 
require("funciones.php"); 
$id=nget("id");
$hora=tget("hora");
ejecute("update movil_viajes set hora=".$hora.
	",estado='OBS',observaciones='Requiere revisión' where id=".$id);
$_SESSION["retorno"]="mv_edit_menu?id=".$id;
$_SESSION["msg"]="Se actualiz&oacute; la hora.";
Redirect("aviso?validar=".$id);
?>

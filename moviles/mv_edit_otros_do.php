<?php
session_start(); 
require("funciones.php"); 
$id=nget("id");
$motivo_recurso=nget("motivo_recurso");
$comentarios=tget("comentarios");
ejecute("update movil_viajes set motivo_recurso=".$motivo_recurso.
	", comentarios=".$comentarios." where id=".$id);
$_SESSION["retorno"]="mv_edit_menu?id=".$id;
$_SESSION["msg"]="Se actualizaron datos.";
Redirect("aviso");
?>

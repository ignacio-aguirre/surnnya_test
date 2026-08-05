<?php
include("Funciones.php"); 
session_start();
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
if($_SESSION['gl_tablahogares']!="1") header("Location: error_noautorizado");
$id=$_GET["id"];
$hogares_mail=tget("Hogares_Mail");
$unidad_tecnica=nget("unidad_tecnica");
$direccion_operativa=nget("direccion_operativa");
$poblacion=tget("poblacion");
$transporte=nget("transporte");
ejecute("update dispositivos set hogares_mail=".$hogares_mail.", unidad_tecnica=".$unidad_tecnica.
",direccion_operativa=".$direccion_operativa.", poblacion=".$poblacion.", transporte=".$transporte." where dispositivos.id=".$id);
Redirect("hogares");
?>
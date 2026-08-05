<?php
session_start();
include("Funciones.php");
$registro=$_GET["registro"];
$mba=nget("mba");
ejecute("update rua_nomina set motivo_baja=".$mba." where id=".$registro);
exit;
?>
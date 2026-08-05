<?php
session_start();
include("Funciones.php");
$registro=$_GET["registro"];
$org=tget("org");
ejecute("update rua_nomina set organismo=".$org." where id=".$registro);
exit;
?>
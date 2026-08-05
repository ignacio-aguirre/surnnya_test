<?php
session_start();
include("Funciones.php");
$registro=$_GET["registro"];
$pod=nget("pod");
ejecute("update rua_nomina set poder=".$pod." where id=".$registro);
exit;
?>
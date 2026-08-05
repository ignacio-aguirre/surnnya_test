<?php
session_start();
include("Funciones.php");
$registro=$_GET["registro"];
$baj=fget("baj");
ejecute("update rua_nomina set f_baja=".$baj." where id=".$registro);
exit;
?>
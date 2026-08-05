<?php
session_start();
include("Funciones.php");
$registro=$_GET["registro"];
$fal=fget("fal");
ejecute("update rua_nomina set f_alta_laboral=".$fal." where id=".$registro);
exit;
?>
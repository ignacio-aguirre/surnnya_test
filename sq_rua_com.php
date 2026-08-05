<?php
session_start();
include("Funciones.php");
$registro=$_GET["registro"];
$com=tget("com");
ejecute("update rua_nomina set comentarios=".$com." where id=".$registro);
exit;
?>
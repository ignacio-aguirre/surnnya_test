<?php
session_start();
include("Funciones.php");
$legajo=tget("legajo");
$descripcion=un_campo("select nombre from atenna_familias where legajofamilia=".$legajo);
echo $descripcion;
exit;
?>
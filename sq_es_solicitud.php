<?php
session_start();
include("Funciones.php");
$id=nget("id");
$f=un_campo("select fecha_ingreso from es_participaciones where id=".$id); 
echo ffec($f);
exit;
?>
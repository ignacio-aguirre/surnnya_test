<?php
include("funciones.php"); 
session_start();
$acronimo=tget("acronimo");
$id=un_campo("select id from movil_usuarios where baja is null and acronimo=".$acronimo." limit 1");
echo $id;
exit();
?>
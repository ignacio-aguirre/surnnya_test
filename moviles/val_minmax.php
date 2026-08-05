<?php
include("funciones.php"); 
session_start();
$tipo=nget("tipo");
$resp=un_campo("select concat(capacidad_min,';',capacidad_max) as capacidades from movil_renglones where id=".$tipo);
echo $resp;
exit();
?>
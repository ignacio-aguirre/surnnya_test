<?php
include("funciones.php"); 
session_start();
$id=nget("id");
$resp=un_campo("select estado from movil_viajes where id=".$id);
echo $resp;
exit();
?>
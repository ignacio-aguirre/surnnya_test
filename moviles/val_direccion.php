<?php
include("funciones.php"); 
session_start();
$id=nget("id");
$resp=un_campo("select direccion from domicilios where id=".$id);
echo $resp;
exit();
?>
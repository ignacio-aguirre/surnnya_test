<?php
session_start();
include("Funciones.php");
$id=nget("id");
$f=un_campo("select fecha from es_acciones where id=".$id); 
echo ffec($f);
exit;
?>
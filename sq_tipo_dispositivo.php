<?php
include("Funciones.php");
session_start();
$id=$_GET["id"]; 
echo un_campo("select tipo_dispositivo from dispositivos where dispositivos.id=".$id); 
?>
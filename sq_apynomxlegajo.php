<?php
session_start();
include("Funciones.php");
$legajo=nget("legajo");
echo un_campo("select case when apellidos is null then null else concat(apellidos,', ',nombres,' DNI ' ,
case when sujetosdni is null then '' else sujetosdni end) end from sujetos where legajo=".$legajo);
exit;
?>
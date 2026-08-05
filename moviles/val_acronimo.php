<?php
include("funciones.php"); 
session_start();
$acronimo=tget("acronimo");
$cnt=un_campo("select count(*) from movil_usuarios where acronimo=".$acronimo);
echo $cnt;
exit();
?>
<?php
include("../funciones.php"); 
session_start();
$barrio=tget("barrio");
echo un_campo("select comuna from barrios_caba where barrio=".$barrio." limit 1");
exit();
?>
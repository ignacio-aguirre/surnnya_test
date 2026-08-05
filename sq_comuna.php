<?php
include("Funciones.php"); 
session_start();
$tipo=$_GET["tipo"];
if($tipo=="1"){
 $barrio=nget("barrio");
 echo un_campo("select comuna from barrios_caba where idbarrios_caba=".$barrio." limit 1");
};
?>
<?php
include("funciones.php");
session_start();
$id=$_GET['id'];
$orig=un_campo("select ruta from archivos where idarchivos=".$id); 
$dest="temp/".sacapath($orig);
if (copy($orig,$dest)) {
sleep(3);Redirect(sacamas($dest));};
?>
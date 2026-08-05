<?php
include("funciones.php");
session_start();
$id="";
$ruta="";
if(isset($_GET['id'])) {
 $id=$_GET['id'];
 $orig=un_campo("select ruta from archivos where idarchivos=".$id);
} else{ $orig=$_GET['ruta'];};
$nomb=substr($orig,17);
$nomb="descarga".$id.substr($nomb,strpos($nomb,"."));
$dest="archivos/temp/".$nomb;
if (copy($orig,$dest)) {
sleep(3);Redirect($dest);};
?>
<?php
session_start();
include("Funciones.php");
$apel=tget("apel");
$nomb=tget("nomb");
$ndoc=nget("ndoc");
if($ndoc!="null"){
 $l=un_campo("select legajo from sujetos where sujetosdni=".$ndoc." and apellidos=".$apel." and nombres=".$nomb);
};
if($l==""){
 $l=un_campo("select legajo from sujetos where apellidos=".$apel." and nombres=".$nomb);
 if($l!=""){$l="-".$l;};
};
echo $l;
exit;
?>

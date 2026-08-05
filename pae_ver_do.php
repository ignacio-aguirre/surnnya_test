<?php
include("Funciones.php"); 
session_start();
$id=$_POST["id"];
$observaciones=tpost("observaciones");
ejecute("update pae_nomina set  observaciones=".$observaciones." where id=".$id);
Redirect("pae_ver?id=".$id);
?>
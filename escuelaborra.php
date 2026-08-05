<?php
include("Funciones.php");
session_start(); 
if (!isset($_SESSION['gldispo'])||!isset($_GET['id'])) header ("Location: salir");
$id=$_GET["id"];
$lega=$_GET["legajo"];
ejecute("update sujetos_escuela set baja=curdate() where esco_legajo=".$lega." and idsujetos_escuela=".$id);
Redirect("sujeactescuela?legajo=".$lega);
?>

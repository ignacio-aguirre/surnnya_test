<?php
include("Funciones.php"); 
session_start();
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
$idmenu=$_SESSION["mnu"];
Redirect("menu?mnu=8&id=1");
?>

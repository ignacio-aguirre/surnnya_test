<?php
include("Funciones.php"); 
session_start();
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
if ($_SESSION['menu']!='mnu_trns') header ("Location: salir");
$_SESSION["extendido"]=1;
Redirect("menu?mnu=".$_SESSION["mnu"]);
?>

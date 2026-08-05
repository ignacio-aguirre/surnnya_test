<?php
include("Funciones.php"); 
session_start();
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
if ($_SESSION['menu']!='mnu_dggpp') header ("Location: salir");
Redirect("menu?mnu=".$_SESSION["mnu"]."&id=1");
?>

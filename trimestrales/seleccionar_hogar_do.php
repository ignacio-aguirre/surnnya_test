<?php
include("funciones.php");
session_start();
$_SESSION["hogar"]=$_GET["hogar"];
if(isset($_GET["anio"])){$_SESSION["anio"]=$_GET["anio"];};
if(isset($_GET["trimestre"])){$_SESSION["trimestre"]=$_GET["trimestre"];};

Redirect("menu");
?>
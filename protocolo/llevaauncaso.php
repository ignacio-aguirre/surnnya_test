<?php 
include("funciones.php");
session_start();
tranca();

$_SESSION["caso"]=$_GET["id"];
Redirect("uncaso");
?>

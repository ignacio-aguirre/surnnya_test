<?php
include("Funciones.php");
session_start();
$legajo=$_GET["legajo"];
$_SESSION["legajo"]=$legajo;
Redirect("Suje_Cons_Duros?legajo=".$legajo);
?>
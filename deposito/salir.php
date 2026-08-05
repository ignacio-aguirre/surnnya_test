<?php 
include("funciones.php");
session_start();
session_destroy();
Redirect(".");
?>

<?php
include("Funciones.php");
session_start(); 
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
ejecute("update usuarios set pwcambio=curdate(), password='".$_POST['iactu']."' where id=".$_SESSION['glidusua']);
Redirect("salir?mensaje=Se ha cambiado la password");
?>

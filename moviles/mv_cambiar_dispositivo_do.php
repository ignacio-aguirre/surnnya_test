<?php
session_start();
include("funciones.php");
$_SESSION["hogar"]=$_GET["hogar"];
$_SESSION["bandeja"]=un_campo("select bandeja from dispositivos where id=".$_GET["hogar"]);
if(!$_SESSION["bandeja"]>"0"){die("error, sin bandeja");};
Redirect($_SESSION['menu']);
?>

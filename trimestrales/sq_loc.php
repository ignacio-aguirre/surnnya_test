<?php
include("funciones.php");
session_start();
if(!$_SESSION["hogar"]>"0"){Redirect(".");};
if(isset($_GET["prov"])) $prov=$_GET["prov"];
if(isset($_GET["part"])) $part=$_GET["part"];
$loca=localidades($prov,$part);
echo $loca;
?>
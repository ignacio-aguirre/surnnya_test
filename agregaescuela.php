<?php
include("Funciones.php"); 
session_start();
echo $_GET['legajo'];
echo $_SESSION['gldispo'];
if (!isset($_SESSION['gldispo'])||!isset($_GET['legajo'])) header ("Location: salir");
$nomb=$_GET['inome'];
$lega=$_GET['legajo'];
$loca=$_GET['iloce'];
$cuan=$_GET['icuae'];
$nive=$_GET['inive'];
$refe=$_GET['irefe'];
$obse=$_GET['iobse'];
if($loca=="") $loca="298";
$sql="insert into sujetos_escuela(esco_legajo, esco_nomb, esco_loca, esco_cuan, esco_nive, esco_refe, esco_obse,alta)";
$sql=$sql." values(".$lega.",'".$nomb."', ".$loca.", '".$cuan."', '".$nive."','".$refe."','".$obse."', curdate());";
ejecute($sql);
header('location: '."sujeactescuela?legajo=".$lega);
?>

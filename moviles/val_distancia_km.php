<?php
include("funciones.php"); 
session_start();
if($_GET["lat1"]!="" && $_GET["lon1"]!="" & $_GET["lat2"]!="" && $_GET["lon2"]!=""){
$lat1=$_GET["lat1"]+0;
$lon1=$_GET["lon1"]+0;
$lat2=$_GET["lat2"]+0;
$lon2=$_GET["lon2"]+0;
$dc=distanciaCoord($lat1,$lon1,$lat2,$lon2);
if(intval($dc>100)){
	echo "0";
}
else{ echo $dc;}
} else{echo "0";};
exit();
?>
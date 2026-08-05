<?php
session_start();
include("funciones.php"); 
$id=nget("id");
$hora=tget("hora");
$v=un_registro("select * from movil_viajes where id=".$id);
$lista="(";
$nnya=registros("select distinct legajo from movil_pasajeros where viaje=".$id." and tipo_pasajero=1 and legajo>0");
while($n=mysqli_fetch_assoc($nnya)){
	$lista=$lista.si($lista=="(","",",").$n["legajo"];
};
$lista=$lista.")";

if($lista!="()"){
  if($v["dispositivo"]>"0"){
     $oviajes=registros("select legajo,hora from movil_pasajeros left join movil_viajes on viaje=movil_viajes.id where tipo_pasajero=1 and estado<>'REC' and dispositivo=".$v["dispositivo"]." and fecha=".$v["fecha"]." and legajo in ".$lista." and viaje<>".$id);}
 else{
     $oviajes=registros("select legajo,hora from movil_pasajeros left join movil_viajes on viaje=movil_viajes.id where tipo_pasajero=1 and estado<>'REC' and sector=".$v["sector"]." and fecha=".$v["fecha"]." and legajo in ".$lista-" amd viaje<>".$id);};
     

while($ov=mysqli_fetch_assoc($oviajes)){
  $h1=substr($ov["hora"],0,5);
  $h2=$hora;
  $difh=dh($h1,$h2);
  if($difh<65) {echo "1"; break;} 
    
};
};
?>
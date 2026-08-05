<?php
include("funciones.php");
session_start();
$nnya=$_SESSION["nnnya_actual"];
$hogar=$_SESSION["hogar"];
$trimestre=$_SESSION["trimestre"];
$anio=$_SESSION["anio"];
$trimestral=un_campo("select id from trimestrales where anio=".$anio." and trimestre=".$trimestre." and hogar=".$hogar." and legajo=".$nnya);
$id=un_campo("select id from trim_vinculaciones where hogar=".$hogar." and legajo=".$nnya." and trimestre=".$trimestre." and anio=".$anio);
if(!$id>0) $id=inserte("insert into trim_vinculaciones(hogar,legajo,trimestre,anio,trimestral) values(".$hogar.",".$nnya.",".$trimestre.",".$anio.",".$trimestral.")");
$vin_tuvo=npost("vin_tuvo");
$vin_quien=npost("vin_quien");
$vin_frecuencia=npost("vin_frecuencia");
$vin_lugar=npost("vin_lugar");
$vin_quien2=npost("vin_quien2");
$vin_frecuencia2=npost("vin_frecuencia2");
$vin_lugar2=npost("vin_lugar2");
$vin_quien3=npost("vin_quien3");
$vin_frecuencia3=npost("vin_frecuencia3");
$vin_lugar3=npost("vin_lugar3");
$vin_quien4=npost("vin_quien4");
$vin_frecuencia4=npost("vin_frecuencia4");
$vin_lugar4=npost("vin_lugar4");
$vin_abrazar=npost("vin_abrazar");
$vin_observaciones=tpost("vin_observaciones");

ejecute("update trim_vinculaciones set 
vin_tuvo=".$vin_tuvo.",
vin_quien=".$vin_quien.",
vin_frecuencia=".$vin_frecuencia.",
vin_lugar=".$vin_lugar.",
vin_quien2=".$vin_quien2.",
vin_frecuencia2=".$vin_frecuencia2.",
vin_lugar2=".$vin_lugar2.",
vin_quien3=".$vin_quien3.",
vin_frecuencia3=".$vin_frecuencia3.",
vin_lugar3=".$vin_lugar3.",
vin_quien4=".$vin_quien4.",
vin_frecuencia4=".$vin_frecuencia4.",
vin_lugar4=".$vin_lugar4.",
vin_abrazar=".$vin_abrazar.",
vin_observaciones=".$vin_observaciones.",
usuario=".$_SESSION["usuario"].", fecha=curdate(),trimestral=".$trimestral." where id=".$id);
Redirect("transicion?proximo=egreso&id=".$trimestral);
?>
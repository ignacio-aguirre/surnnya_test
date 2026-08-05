<?php
require("funciones.php"); 
session_start();
include("encabezado.php");
if(isset($_GET["nnn"])){
  if($_GET["nnn"]=="1"){
    Redirect("mv_dom_nuevo_nn?texto=".$_GET["entrada"]);
  }
}
$direccion=tget("direccion");
$calle=tget("calle");
$calle_cruce=tget("calle_cruce");
$altura=nget("altura");
if($_GET["altura"]=="") $altura="0";
$localidad=tget("localidad");
$partido=tget("partido");
$barrio=tget("barrio");
$comuna=$_GET["comuna"];
if(!isset($_GET["comuna"])){$comuna="0";}
if($comuna==""){$comuna="0";}
$ref_general=tget("ref_general");
if(!isset($_GET["comuna"])){ $comuna="0";}
$longitud=$_GET["longitud"];
$latitud=$_GET["latitud"];

$id_dom=inserte("insert into domicilios(direccion,calle,calle_cruce,altura,localidad,partido,barrio,comuna,longitud,latitud,ref_general) values(".$direccion.",".$calle.",".$calle_cruce.",".$altura.",".$localidad.",".$partido.",".$barrio.",".$comuna.",".$longitud.",".$latitud.",".$ref_general.")");

if($_SESSION["perfil_moviles"]=="1"){
 $domicilio=tsql(formatea_dom($_GET["direccion"]));	
 if($_SESSION["hogar"]>"0"){ 	
 	
   $id=inserte("insert into movil_domicilios(dispositivo,iddomicilios,domicilio,referencia) values(".$_SESSION["hogar"].",".$id_dom.",".$domicilio.",".$ref_general.")");}
 else{
 	$id=inserte("insert into movil_domicilios(sector,iddomicilios,domicilio,referencia) values(".$_SESSION["sector"].",".$id_dom.",".$domicilio.",".$ref_general.")");
 }  

};
echo "Domicilio #".$id_dom." creado";
echo "<script>window.close();
navega('".$_SESSION["menu"]."')</script>";
?>

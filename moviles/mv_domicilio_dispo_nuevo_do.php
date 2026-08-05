<?php
require("funciones.php"); 
session_start();
include("encabezado.php");
$domicilio=tsql(formatea_dom($_GET["entrada"]));
if($domicilio=="''") die("error");
$id_dom=un_campo("select id from domicilios where direccion=".tget("entrada"));
$referencia=tget("referencia");
$tipo_dispositivo=$_GET["tdispo"];
$dispositivo=nget("dispositivo");
$id=inserte("insert into movil_domicilios(".si($tipo_dispositivo=="d","dispositivo","sector").",iddomicilios,domicilio,referencia) values(".$dispositivo.",".$id_dom.",".$domicilio.",".$referencia.")");

$_SESSION["msg"]="Domicilio #".$id." agregado";
$_SESSION["retorno"]="mv_domicilios";
Redirect("aviso");
?>

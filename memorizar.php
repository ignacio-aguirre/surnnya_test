<?php
include("Funciones.php");
session_start();
$tipo="";
$valor="";
$descripcion="";
$retorno="";
if(isset($_GET["retorno"])) $retorno=$_GET["retorno"];
if(!isset($_GET["tipo"])) Redirect("salir");
/* habria que descartar esto */
if(substr($retorno,0,1)=="S") Redirect("suje_cons_archivos?legajo=".substr($retorno,-6));
if(substr($retorno,0,1)=="G") Redirect("grupos2?id=".substr($retorno,1));
if(substr($retorno,0,1)=="M") Redirect("mesalegajos?iid=".substr($retorno,1));
if(substr($retorno,0,1)=="1") Redirect("consmesa");
if(substr($retorno,0,1)=="2") Redirect("consmesa");
if(substr($retorno,0,1)=="3") Redirect("admirecm?id=".substr($retorno,1));
if(substr($retorno,0,1)=="4") Redirect("consmesa");
if(substr($retorno,0,1)=="F") Redirect("af_familias?id=".substr($retorno,1));
if(substr($retorno,0,1)=="H") Redirect("dispositivos_archivos?id=".substr($retorno,1));
die($retorno);
?>


<?php
session_start(); 
require("funciones.php"); 
$id=nget("id");
$distancia_calculada=nget("dis_total");
$hora_adicional="0";
$minutos_adicionales="0";
if($_GET["hora_adicional"]=="on"){
  $hora_adicional="1";
  $minutos_adicionales=nget("minutos_adicionales");
  if($minutos_adicionales==""){
    $minutos_adicionales="0";
  }
}

$tipo_movil=nget("tipo_movil");
$b10_km=nget("b10_km");
ejecute("update movil_viajes set distancia_calculada=".
$distancia_calculada.",tipo_movil=".$tipo_movil.
", hora_adicional=".$hora_adicional.",b10_km=".$b10_km.
", minutos_adicionales=".$minutos_adicionales.
", estado='OBS', observaciones='Requiere revisión' where id=".$id);
$_SESSION["retorno"]="mv_edit_menu?id=".$id;
$_SESSION["msg"]="Se actualiz&oacute; distancia.";
Redirect("aviso?validar=".$id);
?>

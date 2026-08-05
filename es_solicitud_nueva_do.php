<?php
include("Funciones.php");
session_start();

$alcance=nget("alcance");
if($alcance=="1"){
 $legajo=nget("legajo");
}else{
 $legajo="0";
};
$fecha_ingreso=fget("fecha_ingreso");
$solicitante=nget("solicitante");
$solicitante_especificar=tget("solicitante_especificar");
$especialidad=nget("especialidad");
$id=inserte("insert into es_participaciones(legajo,fecha_ingreso,solicitante,solicitante_especificar,alcance,especialidad) values(".
$legajo.",".$fecha_ingreso.",".$solicitante.",".$solicitante_especificar.",".$alcance.",".$especialidad.")");
$cant=un_campo("select count(*) from es_profesionales where profesion=".$especialidad);
if($cant=="1"){
$prof=un_campo("select id from es_profesionales where profesion=".$especialidad);
ejecute("update es_participaciones set profesional=".$prof." where id=".$id);
};
Redirect($_SESSION["menu"]);
?>
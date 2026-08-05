<?php
include("Funciones.php");
session_start();
$id=nget("solicitud");
$fecha=fget("fecha");
$tipo=nget("tipo");
$alcance=nget("alcance");
if($alcance=="2"){$tipo="5";};
$legajo=nget("legajo");
$dispositivo=nget("dispositivo");
$dispositivo_especificar=tget("dispositivo_especificar");
$accion_especificar=tget("accion_especificar");
$especialidad=nget("especialidad");
$modalidad=tget("modalidad");
$observaciones=tget("observaciones");
$profesional="0";
$prof=un_campo("select profesional from es_participaciones where id=".$id);
if($prof>"0"){$profesional=$prof;};
inserte("insert into es_acciones(solicitud,fecha,alcance,tipo,accion_especificar,especialidad,modalidad,observaciones,legajo,dispositivo,dispositivo_especificar,profesional) 
values(".$id.",".$fecha.",".$alcance.",".$tipo.",".$accion_especificar.",".$especialidad.",".$modalidad.",".$observaciones.",".$legajo.",".
$dispositivo.",".$dispositivo_especificar.",".$profesional.")");
Redirect("es_solicitudes_pendientes");
?>
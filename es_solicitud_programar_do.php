<?php
session_start();
include("Funciones.php");
$id=nget("id");
$fecha=dget("fecha_programada");
$hora=tget("hora_programada");
$modalidad=tget("modalidad_programada");
$tipo=nget("tipo");
$dispositivo=tget("dispositivo");
$legajo=un_campo("select legajo from es_participaciones where id=".$id);
$reto=tget("retorno");
$pro=[];
for($i=1;$i<1000;$i++){
  if(isset($_GET["p".(string) $i])){array_push($pro,$i);};
};
if($reto!=tsql("mias")){
 if(count($pro)==0) {die("No se seleccionaron profesionales. Volv&eacute; atr&aacute;s");};
 for($i=0;$i<count($pro);$i++){
  inserte("insert into es_programacion(profesional, legajo, solicitud,fecha,hora,modalidad,tipo,dispositivo) 
  values(".$pro[$i].",".$legajo.",".$id.",".$fecha.",".$hora.",". $modalidad.",".$tipo.",".$dispositivo.")");
 };
 Redirect("es_solicitudes_asignadas");
}else{
 $prof=un_campo("select profesional from es_participaciones where id=".$id);
 inserte("insert into es_programacion(profesional, legajo, solicitud,fecha,hora,modalidad,tipo,dispositivo) 
  values(".$prof.",".$legajo.",".$id.",".$fecha.",".$hora.",". $modalidad.",".$tipo.",".$dispositivo.")");
Redirect("es_solicitudes_mias");
};

function dget($nombre) {
$fecha=$_GET[$nombre];
if($fecha=="") return "null";
return substr($fecha,0,4).substr($fecha,5,2).substr($fecha,8,2);
}

?>
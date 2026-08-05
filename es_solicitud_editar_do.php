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
$fecha_rechazo=fget("fecha_rechazo");
$fecha_fin=fget("fecha_fin");
$motivo_estado=tget("motivo_estado");
$solicitante=nget("solicitante");
$solicitante_especificar=tget("solicitante_especificar");
$especialidad=nget("especialidad");
$profesional=nget("profesional");
$id=nget("id");

ejecute("update es_participaciones set legajo=".$legajo.",fecha_ingreso=".$fecha_ingreso.", fecha_rechazo=".$fecha_rechazo.", fecha_fin=".$fecha_fin.
",motivo_estado=".$motivo_estado.",solicitante=".$solicitante.",solicitante_especificar=".$solicitante_especificar.",alcance=".$alcance.
",especialidad=".$especialidad.", profesional=".$profesional." where id=".$id);
$cant=un_campo("select count(*) from es_profesionales where profesion=".$especialidad);
if($cant=="1"){
 $prof=un_campo("select id from es_profesionales where profesion=".$especialidad);
 ejecute("update es_participaciones set profesional=".$prof." where id=".$id);
};

ejecute("update es_programacion set legajo=".$legajo." where solicitud=".$id);
ejecute("update es_acciones set legajo=".$legajo." where solicitud=".$id);
ejecute("update es_participaciones set fecha_inicio=(select min(fecha) from es_acciones where solicitud=".$id.") where es_participaciones.id=".$id);

if(un_campo("select fecha_fin from es_participaciones where id=".$id)!=""){
   if(fsql(ffec(un_campo("select max(fecha) from es_acciones where solicitud=".$id)))>$fecha_fin){
     ejecute("update es_participaciones set fecha_fin=(select max(fecha) from es_acciones where solicitud=".$id.") where es_participaciones.id=".$id);
   };
};

Redirect($_SESSION["menu"]);
?>
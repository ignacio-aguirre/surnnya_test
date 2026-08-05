<?php
session_start();
include("Funciones.php");
$id=npost("id");
$derivante=npost("derivante");
$derivante_especificar=tpost("derivante_especificar");
$fecha_ingreso=fpost("fecha_ingreso");
$fecha_rechazo=fpost("fecha_rechazo");
$fecha_cancelacion=fpost("fecha_cancelacion");
$ccoo_asignacion=tpost("ccoo_asignacion");
ejecute("update fv_participaciones set derivante=".$derivante.", derivante_especificar=".$derivante_especificar.", fecha_ingreso=".$fecha_ingreso.", fecha_rechazo=".
$fecha_rechazo.", fecha_cancelacion=".$fecha_cancelacion.", ccoo_asignacion=".$ccoo_asignacion.",legajo=0 where id=".$id);
if($fecha_rechazo!="null"||$fecha_cancelacion!="null"){Redirect("fv_solicitudes");};
if($derivante=="-1"){Redirect("una_solicitud3_fv?id=".$id);} else{Redirect("una_solicitud2_fv?id=".$id);};
?>
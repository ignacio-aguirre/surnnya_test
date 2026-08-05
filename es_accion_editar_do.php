<?php
include("Funciones.php");
session_start();
$id=nget("id");
$fecha=fget("fecha");
$tipo=nget("tipo");
$alcance=nget("alcance");
if($alcance=="2"){$tipo="5";};
$dispositivo=nget("dispositivo");
$dispositivo_especificar=tget("dispositivo_especificar");
$accion_especificar=tget("accion_especificar");
$especialidad=nget("especialidad");
$modalidad=tget("modalidad");
$observaciones=tget("observaciones");
ejecute("update es_acciones set fecha=".$fecha.", alcance=".$alcance.", tipo=".$tipo.", accion_especificar=".$accion_especificar.", modalidad=".$modalidad.
", observaciones=".$observaciones.", dispositivo=".$dispositivo.", dispositivo_especificar=".$dispositivo_especificar." where id=".$id);
$solicitud=un_campo("select solicitud from es_acciones where id=".$id);
ejecute("update es_participaciones set fecha_inicio=(select min(fecha) from es_acciones where solicitud=".$solicitud.") where id=".$solicitud);
Redirect("es_acciones");
?>
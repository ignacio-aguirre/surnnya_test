<?php
session_start();
include("Funciones.php");
$id=nget("id");
$profesional=nget("profesional");
$retorno=tget("retorno");
ejecute("update es_participaciones set profesional=".$profesional." where id=".$id);
ejecute("update es_acciones set profesional=".$profesional." where solicitud=".$id." and estado=1");
if($retorno=="'abiertas'"){Redirect("es_solicitudes_abiertas");};
if($retorno=="'asignar'"){Redirect("es_solicitudes_asignar");};
Redirect("es_solicitudes_pendientes");
?>
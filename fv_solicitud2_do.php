<?php
session_start();
include("Funciones.php");
$id=npost("id");
$expediente=tpost("expediente");
$efector=npost("efector");
$fecha_condiciones=fpost("fecha_condiciones");
$fecha_asignacion=fpost("fecha_asignacion");
$ccoo_asignacion=tpost("ccoo_asignacion");
ejecute("update fv_participaciones set expediente=".$expediente.", efector=".$efector.", fecha_condiciones=".$fecha_condiciones.", fecha_asignacion=".$fecha_asignacion.
", ccoo_asignacion=".$ccoo_asignacion." where id=".$id);
Redirect("fv_solicitudes");
?>
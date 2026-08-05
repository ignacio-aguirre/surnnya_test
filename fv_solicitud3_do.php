<?php
session_start();
include("Funciones.php");
$id=npost("id");
$fecha_articulacion=fpost("fecha_articulacion");
$ccoo_asignacion=tpost("ccoo_asignacion");
ejecute("update fv_participaciones set fecha_articulacion=".$fecha_articulacion.", ccoo_asignacion=".$ccoo_asignacion." where id=".$id);
Redirect("fv_solicitudes");
?>
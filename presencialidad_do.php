<?php
session_start();
include("Funciones.php");
$id=nget("id");
$estado=nget("estado");
$fecha_estado=fget("fecha_estado");
$observaciones=tget("observaciones");
inserte("insert into alojados_presencia(vacante,estado,fecha_estado,observaciones,usuario) values (".$id.",".$estado.",".$fecha_estado.",".$observaciones.",".
tsql($_SESSION["glusua"]).")");
ejecute("update hogares_admision set presencialidad=".$estado.", fecha_presencialidad=".$fecha_estado." where idhogares_admision=".$id);
Redirect("presencialidad?id=".$id);
?>
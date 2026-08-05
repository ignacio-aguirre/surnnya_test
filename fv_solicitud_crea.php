<?php
include("Funciones.php");
session_start();
$familia=nget("familia");
$id=inserte("insert into fv_participaciones(familia,fecha_ingreso,legajo,usuario) values(".$familia.",curdate(),-990,".tsql($_SESSION["glusua"]).")");
Redirect("una_solicitud_fv?id=".$id);
?>
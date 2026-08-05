<?php
require("Funciones.php");
session_start();
$id=nget("id");
$hogar=nget("hogar");
$denominacion=tget("denominacion");
$fecha_disposicion=fget("fecha_disposicion");
$disposicion=tget("disposicion");
$registro_unico=nget("registro_unico");
$anio=nget("anio");
$cp_rcp=nget("cp_rcp");
$cp_rcp_fecha=fget("cp_rcp_fecha");
$cp_rol=nget("cp_rol");
$cp_rol_fecha=fget("cp_rol_fecha");
$cp_marcolegal=nget("cp_marcolegal");
$cp_marcolegal_fecha=fget("cp_marcolegal_fecha");
ejecute("update af_familias set denominacion=".$denominacion.", hogar=".$hogar.", disposicion=".$disposicion.", fecha_disposicion=".$fecha_disposicion.
", registro_unico=".$registro_unico.", anio=".$anio.
", cp_rcp=".$cp_rcp.", cp_rcp_fecha=".$cp_rcp_fecha.
", cp_rol=".$cp_rol.", cp_rol_fecha=".$cp_rol_fecha.
", cp_marcolegal=".$cp_marcolegal.", cp_marcolegal_fecha=".$cp_marcolegal_fecha.
" where idaf_familias=".$id);
Redirect("consultafamilias");
?>
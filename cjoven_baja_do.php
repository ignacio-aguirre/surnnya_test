<?php
include("Funciones.php");
session_start();
$id=nget("id");
$baja=fget("fecha");
$alta=fsql(ffec(un_campo("select alta from cjoven_nomina where idcjoven_nomina=".$id)));
if($baja<$alta) die("La fecha de baja no puede ser menor que la de alta");
ejecute("update cjoven_nomina set baja=".$baja." where idcjoven_nomina=".$id);
Redirect("cjoven_nomina");
?>
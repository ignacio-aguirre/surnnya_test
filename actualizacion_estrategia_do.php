<?php

include("Funciones.php");

session_start();

$legajo=nget("legajo");

$estrategia=nget("estrategia");

$estado=nget("estado");

$acciones=tget("acciones");

inserte("insert into sujetos_estrategias (legajo, estrategia, estado, acciones, fecha, usuario) values(".$legajo.",".$estrategia.",".$estado.",".$acciones.",curdate(),".tsql($_SESSION['glusua']).")");

ejecute("update sujetos set es_egreso=".$estrategia.", es_egreso_estado=".$estado." where legajo=".$legajo);

Redirect("suje_cons_alojamiento?legajo=".$legajo);

?>
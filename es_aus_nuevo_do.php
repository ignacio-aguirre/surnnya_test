<?php
include("Funciones.php");
session_start();
include("encabezado-test.php");
$id=nget("id");
$estado=nget("estado");
ejecute("update es_acciones set estado=".$estadp." where id=".$id);
Redirect("es_confirmar_programadas");
?>
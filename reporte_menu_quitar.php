<?php
include("Funciones.php");
session_start();
$id=nget("id");
ejecute("delete from menues_contenido where idmenues_contenido=".$id);
Redirect("reportes");
?>

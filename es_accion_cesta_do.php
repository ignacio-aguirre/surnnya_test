<?php
include("Funciones.php");
session_start();
$id=nget("id");
$estado=nget("estado");
ejecute("update es_acciones set estado=".$estado." where id=".$id);
inicioyfin($id);
Redirect("es_acciones");
?>
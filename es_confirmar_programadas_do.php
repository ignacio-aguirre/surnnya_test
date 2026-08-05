<?php
session_start();
include("Funciones.php");
$id=nget("id");
$observaciones=tget("observaciones");
ejecute("update es_acciones set observaciones=".$observaciones.", estado=2 where id=".$id);
inicioyfin($id);
echo "";
exit;
?>

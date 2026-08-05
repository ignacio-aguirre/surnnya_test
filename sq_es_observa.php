<?php
session_start();
include("Funciones.php");
$id=nget("id");
$observaciones=tget("observaciones");
ejecute("update es_acciones set observaciones=".$observaciones." where id=".$id);
echo un_campo("select observaciones from es_acciones where id=".$id);
exit;
?>
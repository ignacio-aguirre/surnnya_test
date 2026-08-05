<?php 
session_start();
include("funciones.php");
$id=nget("id");
ejecute("update movil_notificaciones set marcada=1,leida=1 where id=".$id);
echo "notificada";
?>

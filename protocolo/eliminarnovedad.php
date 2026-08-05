<?php
include("funciones.php");
session_start();
tranca();
$id=$_GET["id"];
ejecute("update acciones set fecha_baja=curdate(), usuario_baja=".$_SESSION["usuario"]." where id=".$id);
$caso=un_campo("select caso from acciones where id=".$id);
loguea("Eliminar Accion",$caso,$id);
Redirect("acciones");
?>
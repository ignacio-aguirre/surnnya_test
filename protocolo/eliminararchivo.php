<?php
include("funciones.php");
session_start();
tranca();
$id=$_GET["id"];
ejecute("update archivos set fecha_baja=curdate(), usuario_baja=".$_SESSION["usuario"]." where idarchivos=".$id);
$caso=un_campo("select caso from archivos where idarchivos=".$id);
loguea("Eliminar Documento",$caso,$id);
Redirect("documentacion");
?>
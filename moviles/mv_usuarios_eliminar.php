<?php
session_start();
include("funciones.php");
$id=nget("id");
$dispositivo=un_campo("select dispositivo from movil_usuarios where id=".$id);
ejecute("update movil_usuarios set baja=curdate() where id=".$id);
Redirect("mv_usuarios_do?dispositivo=".$dispositivo."&consulta=Consultar");
?>

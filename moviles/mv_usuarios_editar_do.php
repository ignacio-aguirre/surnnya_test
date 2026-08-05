<?php
session_start();
include("funciones.php");
$id=nget("id");
$apellidos=tget("apellidos");
$nombres=tget("nombres");
$email=tget("email");
$acronimo=tget("acronimo");
$password=tget("password");
ejecute("update movil_usuarios
	set apellidos=".$apellidos.",nombres=".$nombres.",email=".$email.",acronimo=".$acronimo.", password=".$password." where id=".$id);
$dispositivo=un_campo("select dispositivo from movil_usuarios where id=".$id);
	
Redirect("mv_usuarios_do?dispositivo=".$dispositivo);


?>
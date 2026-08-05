<?php
include("Funciones.php");
session_start();
$id=nget("id");
ejecute("delete from usuarios_hogares_roles where usuario=".$id);
$hogar=un_campo("select hogar from usuarios_hogares where id=".$id);
ejecute("update usuarios_hogares set baja=curdate() where id=".$id);
Redirect("usuarios_hogares_do?hogar=".$hogar."&consulta=Consultar");
?>

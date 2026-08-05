<?php
include("Funciones.php");
session_start();
$id=nget("id");
$hogar=nget("hogar");
$funcion=tget("funcion");
ejecute("update usuarios_hogares set hogar=".$hogar.", funcion=".$funcion." where id=".$id);
Redirect("usuarios_hogares_do?hogar=".$hogar."&consulta=Consultar");
?>
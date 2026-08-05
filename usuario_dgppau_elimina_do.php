<?php
include("Funciones.php");
session_start();
$id=nget("id");
ejecute("update usuarios set baja=curdate(), estado='BAJA', password='baja2016192".$id."' where id=".$id);
$apyn=un_campo("select concat(apellido,', ',nombre) from usuarios where id=".$id);
$texto="Usuario eliminado ".$apyn;
registro_rapido($texto);
Redirect("usuarios_dgppau");
?>
<?php
session_start();
include("Funciones.php");
$id=npost("id");
ejecute("update localidades_nueva set baja=curdate() where id=".$id);
Redirect("localidades");
?>



<?php
session_start();
include("Funciones.php");
$id=nget("id");
ejecute("update sectores set baja=curdate() where id=".$id);
Redirect("sectores");
?>
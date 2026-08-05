<?php
include("funciones.php");
session_start();
$id=nget("id");
ejecute("update movil_adultos set baja=curdate() where id=".$id);
Redirect("mv_adultos");
?>
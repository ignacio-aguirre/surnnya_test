<?php
session_start();
include("Funciones.php");
$id=nget("id");
ejecute("delete from fv_participaciones where id=".$id);
Redirect("fv_solicitudes");
?>
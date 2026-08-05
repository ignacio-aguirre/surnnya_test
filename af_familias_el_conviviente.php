<?php
session_start();
include("Funciones.php");
$persona=nget("persona");
$familia=nget("familia");
ejecute("update personas set familia_pertenencia=null where idpersonas=".$persona);
Redirect("af_familias_grupos?id=".$familia);
?>

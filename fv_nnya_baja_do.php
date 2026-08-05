<?php
include("Funciones.php");
session_start();
$familia=nget("familia");
$legajo=nget("legajo");
$fecha_baja=fget("fecha_baja");
if(isset($_GET["baja"])){ejecute("update fv_familias_miembros set fecha_baja=".$fecha_baja." where familia=".$familia." and legajo=".$legajo);};
if(isset($_GET["eliminar"])){ejecute("delete from fv_familias_miembros  where familia=".$familia." and legajo=".$legajo);};
Redirect("fv_familias_miembros?id=".$familia);
?>


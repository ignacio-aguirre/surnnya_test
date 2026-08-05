<?php

include("Funciones.php");

session_start();

$id=nget("id");

$legajo=nget("legajo");

ejecute("delete from grupos_legajos where grupo=".$id." and grupo_legajo=".$legajo);

Redirect("grupos2?id=".$id);

?>
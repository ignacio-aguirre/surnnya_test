<?php

include("Funciones.php");

session_start();

$legajo=nget("legajo");

echo un_campo("select case when grupo is null then 0 else 1 end from grupos_legajos where grupo_legajo=".$legajo." limit 1");

?>
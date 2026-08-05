<?php

include("Funciones.php");

session_start();

$id=inserte("insert into grupos (apellidos,categoria) values('grupo nuevo',1)");

Redirect("grupo_editar?id=".$id);

?>
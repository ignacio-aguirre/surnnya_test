<?php

include("Funciones.php");

session_start();

if($_SESSION['gl_editar_sujeto']==0) Redirect($_SESSION["menu"]);

registre();

$id=nget("id");

$apellidos=tget("apellidos");

$categoria=nget("categoria");

ejecute("update grupos set apellidos=".$apellidos.", categoria=".$categoria." where idgrupos=".$id);

Redirect("grupos2?id=".$id);

?>


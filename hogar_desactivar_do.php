<?php
session_start();
include("Funciones.php");
$id=$_GET["id"];
ejecute("update dispositivos set baja=curdate() where dispositivos.id=".$id);
registro_rapido("Desactiv&oacute; el hogar ".un_campo("select nombre from dispositivos where dispositivos.id=".$id));
Redirect("hogares");
?>
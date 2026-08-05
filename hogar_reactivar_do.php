<?php
session_start();
include("Funciones.php");
$id=$_GET["id"];
ejecute("update dispositivos set baja=null where dispositivos.id=".$id);
registro_rapido("Reactiv&oacute; el hogar ".un_campo("select nombre from dispositivos where dispositivos.id=".$id));
Redirect("hogares");
?>
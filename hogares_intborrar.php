<?php
include("Funciones.php"); 
session_start();
$reto=$_SERVER["HTTP_REFERER"];
$id=$_GET["id"];
if (!isset($_SESSION["gldispo"])) header ("Location: salir");
ejecute("update hogares_intervenciones set baja=curdate() where idhogares_intervenciones=".$id);Redirect($reto);
registre();

?>

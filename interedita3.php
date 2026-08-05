<?php
include("Funciones.php"); 
session_start();
if (!isset($_GET["iid"])) header ("Location: salir");
registre();
$id=$_GET["iid"];
$tipo=$_GET["itipo"];
$hosp=nget("hosp");
if($hosp=="0"){$hosp="null";};
$obse=$_GET["iobse"];
ejecute("update intervenciones set inter_tipo=".$tipo.", inter_hosp=".$hosp.", inter_obse='".$obse."' where idintervenciones=".$id);
header("Location: interedita?iid=".$id);

?>


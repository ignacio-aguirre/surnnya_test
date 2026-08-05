<?php
include("Funciones.php"); 
session_start();
if (!isset($_SESSION['gldispo'])||!isset($_GET["iid"])) header ("Location: salir");
registre();
$id=$_GET["iid"];
$oper=$_GET["ioper"];
ejecute("update intervenciones set inter_oper='".$oper."' where idintervenciones=".$id);

header("Location: interedita?iid=".$id);

?>


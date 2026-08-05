<?php
include("Funciones.php"); 
session_start();
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
registre();
$id=$_GET["id"];
$etapa=$_GET["etapa"];
$fecha=fget("fecha");
$comentarios=tget("comentarios");
$usuario=tsql($_SESSION["glusua"]);
ejecute("update pae_nomina set etapa=".$etapa.",f_cambio_etapa=".$fecha." where id=".$id);
inserte("insert into pae_nomina_estados (inclusion,fecha,etapa,comentarios,usuario) values(".$id.",".$fecha.",".$etapa.",".$comentarios.",".$usuario.")");
Redirect("pae_ver?id=".$id);
?>


<?php
include("Funciones.php"); 
session_start();
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
registre();
$id=$_GET["id"];
$fecha=fget("fecha");
$comentarios=tsql("BAJA ".$_GET["comentarios"]);
$usuario=tsql($_SESSION["glusua"]);
ejecute("update pae_nomina set f_baja=".$fecha.", accion_amb='BAJA' where id=".$id);
inserte("insert into pae_nomina_estados (inclusion,fecha,etapa,comentarios,usuario) values(".$id.",".$fecha.",0,".$comentarios.",".$usuario.")");
Redirect("pae_ver?id=".$id);
?>


<?php
include("Funciones.php"); 
session_start();
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
registre();
$legajo=$_GET["legajo"];
$fecha=fget("fecha");
$etapa=nget("etapa");
$comentarios=tget("comentarios");
$id=inserte("insert into pae_nomina(legajo, f_cambio_etapa, f_cons_inf,accion_amb,etapa) values(".$legajo.",".$fecha.",".$fecha.",'ALTA',".$etapa.")");
inserte("insert into pae_nomina_estados(inclusion,etapa,fecha,comentarios,usuario) values(".$id.",".$etapa.",".$fecha.",".$comentarios.",".tsql($_SESSION["glusua"]).")");
Redirect("pae_nomina");
?>


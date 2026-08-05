<?php
include("funciones.php");
session_start();
tranca();
$caso=$_POST["id"];
$f_ingreso=str_replace( "-","",$_POST["f_ingreso"]);
$dispositivo=tsql($_POST["dispositivo"]);
$id=inserte("insert into alojamientos (caso,dispositivo,f_ingreso,usuario) values(".$caso.",".$dispositivo.",".$f_ingreso.",".$_SESSION["usuario"]	.")");

loguea("Ingreso a Dispositivo",$caso,$id);
Redirect("alojamientos");
?>
<?php
include("funciones.php");
session_start();
tranca();
$caso=$_POST["iid"];
$fecha=fsql($_POST["fecha"]);
$descripcion=$_POST["novedad"];
$origen=$_POST["origen"];
$id=inserte("insert into acciones(descripcion,caso,fecha,origen,usuario) values(".tsql($descripcion).",".$caso.",".$fecha.",".$origen.",".$_SESSION["usuario"].")");
loguea("Subir Accion",$caso,$id);
Redirect("acciones");
?>
<?php
include("funciones.php");
session_start();
$apellido=tget("apellido");
$nombre=tget("nombre");

$celular=tget("celular");
$dispositivo=nget("dispositivo");
$tipo_dispositivo=$_GET["td"];
$id=inserte("insert into movil_adultos(apellido,nombre,celular,".si($tipo_dispositivo=="d","dispositivo","sector").") values(".$apellido.",".$nombre.",".$celular.",".$dispositivo.")");
$_SESSION["msg"]="Adulto #".$id." ingresado";
Redirect($_SESSION["menu"]);
?>

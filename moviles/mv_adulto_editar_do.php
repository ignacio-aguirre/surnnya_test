<?php
include("funciones.php");
session_start();
$id=nget("id");
$apellido=tget("apellido");
$nombre=tget("nombre");
$celular=tget("celular");
$dispositivo=$_SESSION["hogar"];
$ndispo=un_campo("select nombre from dispositivos where id=".nulea($dispositivo));
$tdispo="d";
if(!$dispositivo>"0"){
    $dispositivo=$_SESSION["sector"];
    $ndispo=un_campo("select denominacion from sectores where id=".nulea($dispositivo));
    $tdispo="s";
};

ejecute("update movil_adultos set apellido=".$apellido.
  ",nombre=".$nombre.", celular=".$celular.
  " where id=".$id);

Redirect("mv_adultos");
?>

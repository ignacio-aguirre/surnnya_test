<?php
include("funciones.php");
session_start();
tranca();
$id=$_GET["id"];
$caso=un_campo("select caso from alojamientos where id=".$id);
$dispo=un_campo("select dispositivo from alojamientos where id=".$id);
ejecute	("delete from alojamientos where id=".$id);
loguea("Eliminar Alojamiento en ".$dispo,$caso,$id);
Redirect("alojamientos");
?>
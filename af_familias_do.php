<?php
include("Funciones.php");
session_start();
$id=nget("id");
$denominacion=tget("denominacion");
$hogar=nget("hogar");
if($id=="0"){$id=inserte("insert into af_familias(denominacion,hogar) values(".$denominacion.",".$hogar.")");}
else{
 ejecute("update af_familias set denominacion=".$denominacion.", hogar=".$hogar." where idaf_familias=".$id);
};
Redirect("consultafamilias");
?>
<?php 
include("Funciones.php");
session_start();
$id=nget("id");
$estado1=nget("estado1");
$fecha_estado1=fget("fecha_estado1");
inserte("insert into af_familias_estados(familia,estado1,fecha,usuario) values(".$id.",".$estado1.",".$fecha_estado1.",".tsql($_SESSION["glusua"]).")");
ejecute("update af_familias set estado1=".$estado1.", fecha_estado1=".$fecha_estado1." where idaf_familias=".$id);
if($estado1=="1"){ejecute("update af_familias set fecha_disposicion=".$fecha_estado1." where idaf_familias=".$id." and fecha_disposicion is null");};
Redirect("af_cambiaestado?id=".$id);
?>
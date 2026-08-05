<?php 
include("Funciones.php");
session_start();
$id=nget("id");
$estado2=nget("estado2");
$fecha_estado2=fget("fecha_estado2");
inserte("insert into af_familias_estados(familia,estado2,fecha,usuario) values(".$id.",".$estado2.",".$fecha_estado2.",".tsql($_SESSION["glusua"]).")");
ejecute("update af_familias set tipo_prestacion=".$estado2.", fecha_estado2=".$fecha_estado2." where idaf_familias=".$id);
if($estado2=="11"){
	ejecute("update af_familias set fecha_baja=".$fecha_estado2." where idaf_familias=".$id); 
}else{
	ejecute("update af_familias set fecha_baja=null where idaf_familias=".$id); 
};
Redirect("af_cambiaestado?id=".$id);
?>
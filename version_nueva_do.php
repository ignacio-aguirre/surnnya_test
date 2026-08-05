<?php
include("Funciones.php"); 
session_start();
$modulo=tget("modulo");
$entorno=tget("entorno");
$ver_1=nget("ver_1");
$ver_2=nget("ver_2");
$ver_3=nget("ver_3");
$fecha=str_replace("-","",$_GET["fecha"]);
$cambios=tget("cambios");
$id=un_campo("select id from versiones where modulo=".$modulo." and entorno=".$entorno);
if(!$id>0){$id=inserte("insert into versiones(modulo,entorno) values(".$modulo.",".$entorno.")");};
ejecute("update versiones set ver_1=".$ver_1.", ver_2=".$ver_2.", ver_3=".$ver_3.
	",fecha=".$fecha." where id=".$id);
inserte("insert into versiones_cambios(modulo,entorno,ver_1,ver_2,ver_3,fecha,log_cambios) values(".$modulo.",".$entorno.",".$ver_1.",".$ver_2.",".$ver_3.",".$fecha.",".$cambios.")");
Redirect($_SESSION["menu"]);
?>
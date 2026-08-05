<?php
include("Funciones.php"); 
session_start();
$legajo=nget("legajo");
if($legajo==""){die("sin legajo");};
$registro=un_campo("select registro from rua_nomina where legajo=".$legajo);
if($registro==""){
$f_ingreso=fsql(ffec($_GET["f_ingreso"]));
$estado="1";
$id=inserte("insert into rua_nomina(legajo,f_ingreso,estado) values(".$legajo.",".$f_ingreso.",".$estado.")");
$registro="RUA-".substr($f_ingreso,0,4)."-".ceros($id)."-CDNNYA";
ejecute("update rua_nomina set registro=".tsql($registro)." where id=".$id);

Redirect("rua_nomina");
} else {die("con registro ".$registro);};
function ceros($n){
	return substr("00000000".$n,-8);
}
?>

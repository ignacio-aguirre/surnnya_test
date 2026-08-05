<?php
include("funciones.php");
session_start();
$proc=un_registro("select * from movil_procesos where id=".$_SESSION["idproceso"]);
$desdes=fsql(ffec($proc["desde_ab"]));
$hastas=fsql(ffec($proc["hasta"]));

$_SESSION["msg"]="Bloqueo 1 ok";

$cntb1=registros("select count(*) as cant from movil_viajes where fecha between ".$desdes." and ".$hastas." and bandeja=1 group by bandeja");
		
if($cntb1>0)	{
  ejecute("update movil_viajes 
	set movil_viajes.bandeja=6,f_solicitud=".$_SESSION["hoy_s"].",bloqueo=1 where movil_viajes.bandeja=1 and 	fecha between	".$desdes." and ".$hastas);
}

ejecute("update movil_procesos set b1_6=1 where id=".$_SESSION["idproceso"]);
$_SESSION["msg"]="Bloqueo 1 ok";



$_SESSION["retorno"]=$_SESSION["menu"];
Redirect("aviso");
?>

<?php
session_start();
include("funciones.php");
$cosa=valorizar();

if($_SESSION['supervisa']=="B13"){
	
	ejecute("update movil_viajes set bandeja=7,bloqueo=2,lote_envio=".$_SESSION["idproceso"]." where bandeja=6 and estado='APR'");
	ejecute("update movil_viajes set bandeja=90,bloqueo=2 where bandeja=6 and estado<>'APR'");
	ejecute("update movil_procesos set b1_6=1, b2_6=1 where id=".$_SESSION['idproceso']);
};

$_SESSION["msg"]="Bloqueo 2 realizado";
$_SESSION["retorno"]="salir";
Redirect("aviso");
?>

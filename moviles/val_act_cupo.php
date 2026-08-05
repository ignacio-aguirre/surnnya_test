<?php
session_start();
include("funciones.php"); 
$dispo=nget("dispo");
$cupo=nget("cupo");
ejecute("update movil_cupos set cupo_diario=".$cupo." where dispositivo=".$dispo);
echo un_campo("select cupo_diario from movil_cupos where dispositivo=".$dispo);
exit();
?>
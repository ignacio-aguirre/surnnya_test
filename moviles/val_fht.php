<?php
include("funciones.php"); 
session_start();
$id=nget("id");
$viaje=un_registro("select dispositivo, fecha,hora from movil_viajes where id=".$id);
$numero=un_campo("select celular_moviles from dispositivos where id=".$viaje["dispositivo"]);
$resp=array(["fecha" => ffec($viaje["fecha"])],["hora" => $viaje["hora"]],["numero" => $numero]);
echo json_encode($resp);
exit();
?>
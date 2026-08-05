<?php
session_start();
require("funciones.php"); 
$id=nget("id");
$cumplido=nget("cumplido");
$motivo=tsql("motivo");
$u_cert=tsql($_SESSION["nusuario"]);
ejecute("update movil_viajes set cumplido=".$cumplido.", usuario_certificante=".$u_cert." where id=".$id);
if($cumplido=="-1"){
	ejecute("update movil_viajes set observaciones='No realizado' , comentarios=concat(comentarios,' NO REALIZADO',".$motivo.") where id=".$id);
}
Redirect("mv_viajes_certificar");
?>
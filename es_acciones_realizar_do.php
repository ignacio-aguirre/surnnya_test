<?php
include("Funciones.php"); 
session_start();
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
$fini=str_replace("-","",$_GET["fini"]);
$ffin=str_replace("-","",$_GET["ffin"]);
if($fini<=$ffin){
 $acc=registros("select es_acciones.id,solicitud,fecha_inicio,fecha 
 from es_acciones 
 left join es_participaciones on solicitud=es_participaciones.id where estado=1 and fecha between ".$fini." and ".$ffin);	
 while($a=mysqli_fetch_assoc($acc)){
	ejecute("update es_acciones set estado=2 where id=".$a["id"]);
	inicioyfin($a["id"]);	
 };
 Redirect("es_acciones");
}
else {echo "error";};
?>
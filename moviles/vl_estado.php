<?php
include("funciones.php"); 
session_start();
$id=nget("id");
$estado=tget("estado");
$texto="";
$v=un_registro("select * from movil_viajes where id=".$id);
if(isset($_GET["texto"])){
if($_GET["texto"]!=""){$texto=$_GET["texto"];};
}
ejecute("update movil_viajes set estado=".$estado." where id=".$id);

if($texto!="" && $_GET["estado"]=="OBS"){
		ejecute("update movil_viajes set observaciones=".tsql($texto)." where id=".$id);
};	
if($_GET["estado"]=='PRO'||$_GET["estado"]=='APR')	{
		ejecute("update movil_viajes set observaciones=null where id=".$id);
}
$dispo=$v["dispositivo"];
$notif="";

if($dispo>"0"){

    if($_GET["estado"]=="OBS"){
    	$texto="Observado viaje del ".ffec($v["fecha"])." con partida a las ".substr($v["hora"],0,5)."-".$texto;
    	$notif=notificar($dispo,$texto);
    };
	
	
};

if($notif!=""){ejecute("update movil_viajes set observaciones=concat(observaciones,' ',".tsql($notif).") where id=".$id);};
echo un_campo("select estado from movil_viajes where id=".$id);
exit();
?>
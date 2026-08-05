<?php
session_start();
include("funciones.php");
$id=nget("id");
$fini=str_replace("-","",$_GET["fecha_inicio"]);
$ffin=str_replace("-","",$_GET["fecha_fin"]);
$sql="select fecha from fechas where fecha between ".$fini." and ".$ffin." and fecha>curdate() ".diasem($_GET["ds"]);
$dias=nget("dias");
if($dias=="1"){$sql=$sql." and laborable=1 ";};
if($dias=="2"){$sql=$sql." and laborable=0 ";};

$fechas=registros($sql);
$msg="";
while($f=mysqli_fetch_assoc($fechas)){
  $fecha=fsql(ffec($f["fecha"]));
  $idn=inserte("insert into movil_viajes(dispositivo,sector,fecha,hora,tipo_tipo,tipo_movil,empresa,partida,destino_1,destino_2,destino_3,destino_4,
    distancia_calculada,usuario,pasajeros_alojados,
pasajeros_acompaniantes,motivo_recurso,comentarios,estado,observaciones,bandeja,agrupador)  select dispositivo,sector,".$fecha.",hora,tipo_tipo,tipo_movil,empresa,partida,destino_1,destino_2,destino_3,destino_4,distancia_calculada,usuario,
pasajeros_alojados,0,motivo_recurso,comentarios,'OBS','Se requiere adulto',".$_SESSION['bandeja'].",id from movil_viajes where id=".$id);
  ejecute("insert into movil_pasajeros(viaje,tipo_pasajero,pas_nombre,legajo) select ".$idn.",1,pas_nombre,legajo from movil_pasajeros
 where viaje=".$id." and tipo_pasajero=1");

 $msg=$msg."<br>Viaje ".$idn." generado";



};
$_SESSION["msg"]=$msg;
$_SESSION["retorno"]=$_SESSION['menu'];
Redirect("aviso");


function diasem($ds){
 $resp=" and ds in(";
 if(strpos("PP".$ds,"L")>0){$resp=$resp.tsql("lun").",";};
 if(strpos("PP".$ds,"M")>0){$resp=$resp.tsql("mar").",";};
 if(strpos("PP".$ds,"X")>0){$resp=$resp.tsql("mie").",";};
 if(strpos("PP".$ds,"J")>0){$resp=$resp.tsql("jue").",";};
 if(strpos("PP".$ds,"V")>0){$resp=$resp.tsql("vie").",";};
 if(strpos("PP".$ds,"S")>0){$resp=$resp.tsql("sab").",";};
 if(strpos("PP".$ds,"D")>0){$resp=$resp.tsql("dom").",";};
 if(substr($resp,-1)==","){$resp=substr($resp,0,$resp.lenght-1);};
 $resp=$resp.") ";
 return $resp;
}


?>

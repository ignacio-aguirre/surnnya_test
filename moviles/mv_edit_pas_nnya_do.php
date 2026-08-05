<?php
session_start();
include("funciones.php");
$bandeja=$_SESSION["bandeja"];
$id=nget("id");
$v=un_registro("select * from movil_viajes where id=".$id);
$pasajeros_alojados=nget("pasajeros_alojados");

ejecute("update movil_viajes set pasajeros_alojados=".$pasajeros_alojados.",estado='OBS',observaciones='Requiere revisión' where id=".$id);

// pasajeros 
ejecute("delete from movil_pasajeros where viaje=".$id." and tipo_pasajero=1");
for($i=1; $i<=intval($pasajeros_alojados);$i++){
  $legajo=nget("lega".$i);
  if($legajo>"100"){
  $nombre=tsql(un_campo("select nombres from sujetos where legajo=".$legajo));
  inserte("insert into movil_pasajeros(viaje,tipo_pasajero,pas_nombre,legajo) values(".$id.",1,".$nombre.",".$legajo.")");
};
};

$_SESSION["retorno"]="mv_edit_menu?id=".$id;
$_SESSION["msg"]="Se actualiz&oacute; pasajeros_alojados.";
Redirect("aviso?validar=".$id);
?>

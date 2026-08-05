<?php
session_start();
include("funciones.php");
$bandeja=$_SESSION["bandeja"];
$id=nget("id");
$v=un_registro("select * from movil_viajes where id=".$id);
$pasajeros_acompaniantes=nget("pasajeros_acompaniantes");
ejecute("update movil_viajes set pasajeros_acompaniantes=".$pasajeros_acompaniantes.",estado='OBS', observaciones='Requiere revisión' where id=".$id);

// pasajeros 
ejecute("delete from movil_pasajeros where viaje=".$id." and tipo_pasajero=2");
for($i=1; $i<=intval($pasajeros_acompaniantes);$i++){
  $nombre=tget("a".$i);
  $celular=tget("acel".$i);
  if($celular!=""){
  
    inserte("insert into movil_pasajeros(viaje,tipo_pasajero,pas_nombre,celular) values(".$id.",2,$nombre,".$celular.")");
  
  };  
    
  
};

$_SESSION["retorno"]="mv_edit_menu?id=".$id;
$_SESSION["msg"]="Se actualiz&oacute; pasajeros acomp.";
Redirect("aviso?validar=".$id);
?>

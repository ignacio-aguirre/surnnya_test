<?php 
session_start();
include("funciones.php");
$i1=nget("id1");
$i2=nget("id2");
$primero=nget("primero");
if($primero==1){
	$id1=$i1;
	$id2=$i2;
}
else{
	$id1=$i2;
	$id2=$i1;
};
ejecute("update movil_viajes set estado='UNI' where id=".$id2);
$pasajeros=registros("select * from movil_pasajeros where viaje=".$id2);

while($p=mysqli_fetch_assoc($pasajeros)){
	if($p["tipo_pasajero"]=="1"){
		$cnt=un_campo("select count(*) from movil_pasajeros where tipo_pasajero=1 and viaje=".$id1." and legajo=".$p["legajo"]);
		if($cnt=="0"){
			inserte("insert into movil_pasajeros(viaje,tipo_pasajero,pas_nombre,legajo) values(".
				$id1.",1,".tsql($p["pas_nombre"]).",".$p["legajo"].")");
		}
	}else{
		$cnt=un_campo("select count(*) from movil_pasajeros where tipo_pasajero=2 and viaje=".$id1." and pas_nombre=".tsql($p["pas_nombre"]));
		if($cnt=="0"){
			inserte("insert into movil_pasajeros(viaje,tipo_pasajero,tipo,pas_nombre,celular) values(".
				$id1.",2,".tsql($p["pas_nombre"]).",".$p["celular"].")");
		}
	};
};
$pasajeros_alojados=un_campo("select count(*) from movil_pasajeros  where tipo_pasajero=1 and viaje=".$id1);
$pasajeros_acompaniantes=un_campo("select count(*) from movil_pasajeros  where tipo_pasajero=2 and viaje=".$id1);
$dista=un_campo("select distancia_calculada from movil_viajes where id=".$id2);
$destino2=tsql(un_campo("select destino_1 from movil_viajes where id=".$id2));
ejecute("update movil_viajes set destino_2=".$destino2.", pasajeros_alojados=".$pasajeros_alojados.", pasajeros_acompaniantes=".$pasajeros_acompaniantes.", estado='OBS', observaciones='Revisar distancia' , distancia_calculada=distancia_calculada+".$dista." where id=".$id1);
Redirect("mv_revision_propia");
?>
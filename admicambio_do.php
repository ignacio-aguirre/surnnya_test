<?php
include("Funciones.php"); 
session_start();
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
registre();
$id=$_GET["id"];
$fecha=fget("fecha");
$mote="4";
$motivo=tget("motivo");
$legajo=un_campo("select admi_legajo from hogares_admision where idhogares_admision=".$id);
$dispositivo_origen=nget("dispositivo_origen");
$dispositivo_destino=nget("dispositivo_destino");
// BAJA
ejecute("update hogares_admision set admi_baja=".$fecha.", admi_mote=".$mote.", permanencia=datediff(".$fecha.", admi_alta)+1 where idhogares_admision=".$id);
$idab=inserte("insert into altasybajas (vacante,operacion,fecha_operacion,legajo,hogar) values(".$id.",'B',".$fecha.",".$legajo.",".$dispositivo_origen.")");
ejecute("insert into altasybajas_log (legajo,hogar,operacion,fecha_operacion,accion,fecha_accion,usuario) values(".$legajo.",".$dispositivo_origen.",'B',".$fecha.",'Registro',curdate(),".tsql($_SESSION["glusua"]).")");
/* presencialidad */
inserte("insert into alojados_presencia(vacante,estado,fecha_estado,observaciones,usuario) values(".$id.",3,".$fecha.",'Egreso',".tsql($_SESSION["glusua"]).")");
  ejecute("update hogares_admision set presencialidad=3, fecha_presencialidad=".$fecha." where idhogares_admision=".$id);

// ALTA
$id_alta=un_campo("select idhogares_admision from hogares_admision where admi_legajo=".$legajo." and admi_alta is null and admi_fderiv is not null and admi_susp is null limit 1");
ejecute("update hogares_admision set admi_alta=".$fecha.", admi_moti=5 where idhogares_admision=".$id_alta);
$idab=inserte("insert into altasybajas (vacante,operacion,fecha_operacion,legajo,hogar) values(".$id_alta.", 'A',".$fecha.",".$legajo.",".$dispositivo_destino.")");
ejecute("insert into altasybajas_log (legajo,hogar,operacion,fecha_operacion,accion,fecha_accion,usuario) values(".$legajo.",".$dispositivo_destino.",'A',".$fecha.",'Registro',curdate(),".tsql($_SESSION["glusua"]).")");
   /* actualizacion de permanencia_anterior */
  $pante=un_campo("select perm_anterior+permanencia as ante from hogares_admision where idhogares_admision=".$id);
  ejecute("update hogares_admision set baja_anterior=".$fecha.", perm_anterior=".$pante." where idhogares_admision=".$id_alta);
  /* presencialidad */
  inserte("insert into alojados_presencia(vacante,estado,fecha_estado,observaciones,usuario) values(".$id_alta.",1,".$fecha.",'Ingreso',".tsql($_SESSION["glusua"]).")");
  ejecute("update hogares_admision set presencialidad=1, fecha_presencialidad=".$fecha." where idhogares_admision=".$id_alta);
// CAMBIO
inserte("insert into alojados_cambios(fecha,legajo,motivo,dispositivo_origen, dispositivo_destino, usuario, idalta, idbaja) values(".$fecha.",".$legajo.",".
$motivo.",".$dispositivo_origen.",".$dispositivo_destino.",".tsql($_SESSION["glusua"]).",".$id_alta.",".$id.")");
Redirect("admicons3?mensaje=Subir notas de alta y baja por el cambio de hogar");
?>

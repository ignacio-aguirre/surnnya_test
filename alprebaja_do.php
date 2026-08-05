<?php
include("Funciones.php"); 
session_start();
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
registre();
$id=$_GET["id"];
$fech=fget("fecha");
$mote=nget("mote");
$legajo=un_campo("select admi_legajo from hogares_admision where idhogares_admision=".$id);
$hogar=un_campo("select admi_hogar from hogares_admision where idhogares_admision=".$id);
ejecute("update hogares_admision set admi_baja=".$fech.", admi_mote=".$mote.", permanencia=datediff(".$fech.", admi_alta)+1 where idhogares_admision=".$id);
$idab=inserte("insert into altasybajas (vacante,operacion,fecha_operacion,legajo,hogar) values(".$id.",'B',".$fech.",".$legajo.",".$hogar.")");
ejecute("insert into altasybajas_log (legajo,hogar,operacion,fecha_operacion,accion,fecha_accion,usuario) values(".$legajo.",".$hogar.",'B',".$fech.",'Registro',curdate(),".tsql($_SESSION["glusua"]).")");
/* presencialidad */
inserte("insert into alojados_presencia(vacante,estado,fecha_estado,observaciones,usuario) values(".$id.",3,".$fech.",'Egreso',".tsql($_SESSION["glusua"]).")");
  ejecute("update hogares_admision set presencialidad=3, fecha_presencialidad=".$fech." where idhogares_admision=".$id);
inserte("insert into sujetos_vivienda(legajo,tipovivienda,fecha) values(".$legajo.",".$mote.",".$fech.")");
Redirect("subir_archivos?altabaja=".$idab."&ret=".$_SESSION["menu"]);
?>

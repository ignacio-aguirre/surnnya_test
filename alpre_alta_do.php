<?php 
include("Funciones.php"); 
session_start();
$fecha=fget("fecha");
$legajo=nget("legajo");
$hogar=nget("admi_hogar");
$id=inserte("insert into hogares_admision(admi_legajo,admi_hogar,admi_alta) values(".$legajo.",".$hogar.",".$fecha.")");
$idab=inserte("insert into altasybajas (vacante,operacion,fecha_operacion,legajo,hogar) values(".$id.", 'A',".$fecha.",".$legajo.",".$hogar.")");
ejecute("insert into altasybajas_log (legajo,hogar,operacion,fecha_operacion,accion,fecha_accion,usuario) values(".$legajo.",".$hogar.",'A',".$fecha.",'Registro',curdate(),".tsql($_SESSION["glusua"]).")");
   /* control de cambio de hogar */
   $idaux=un_campo("select idhogares_admision from hogares_admision where admi_legajo=".$legajo." and datediff(".$fecha.",admi_baja)<2");
   if($idaux!=""){
     ejecute("update hogares_admision set admi_moti=5 where idhogares_admision=".$id);
     ejecute("update hogares_admision set admi_mote=4 where idhogares_admision=".$idaux);
   };
   /* actualizacion de permanencia_anterior */
  $uba=un_registro("select admi_baja, datediff(".$fecha.", admi_baja) as dias, perm_anterior+permanencia as ante from hogares_admision where admi_legajo=".$legajo." and admi_alta <".$fecha." order by admi_alta desc limit 1");
  if(ffec($uba["admi_baja"])!=""){
    ejecute("update hogares_admision set baja_anterior=".fsql(ffec($uba["admi_baja"])).", perm_anterior=".si($uba["dias"]>365,"0",$uba["ante"])." where idhogares_admision=".$id);
  }
  else{
    ejecute("update hogares_admision set perm_anterior=0 where idhogares_admision=".$id);
  };
  /* presencialidad */
  inserte("insert into alojados_presencia(vacante,estado,fecha_estado,observaciones,usuario) values(".$id.",1,".$fecha.",'Ingreso',".tsql($_SESSION["glusua"]).")");
  ejecute("update hogares_admision set presencialidad=1, fecha_presencialidad=".$fecha." where idhogares_admision=".$id);
Redirect("subir_archivos?altabaja=".$idab."&ret=".$_SESSION["menu"]); 
?>
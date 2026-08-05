<?php
include("Funciones.php"); 
session_start();
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
$id=nget("idd");
$fped=fget("fped");
$deri=nget("deriv");
$derc=tget("deriv_cual");
$cate=nget("cate");
$proc=nget("proc");
$prcc=tget("proc_cual");
$hosp="0";
if($proc=="10"||$proc=="11") {
 $hosp=$_GET["hospital"];if($prcc=="") $prcc=un_campo("select descripcion from salud_establecimientos where idsalud_establecimientos=".$hosp);};
$moti=nget("moti");
$halt=nget("halt");
$falt=fget("falt");
if($_GET["falt"]==""||$halt=="null")  $falt="null";
ejecute("update hogares_admision set admi_fped=".$fped." where idhogares_admision=".$id);
ejecute("update hogares_admision set admi_deriv=".$deri." where idhogares_admision=".$id);
ejecute("update hogares_admision set admi_deriv_cual=".$derc." where idhogares_admision=".$id);
ejecute("update hogares_admision set admi_cate=".$cate." where idhogares_admision=".$id);
ejecute("update hogares_admision set admi_proc=".$proc." where idhogares_admision=".$id);
ejecute("update hogares_admision set admi_proc_cual=".$prcc." where idhogares_admision=".$id);
ejecute("update hogares_admision set admi_halt=".$halt." where idhogares_admision=".$id);
ejecute("update hogares_admision set admi_falt=".$falt." where idhogares_admision=".$id);
ejecute("update hogares_admision set admi_moti=".$moti." where idhogares_admision=".$id);
$defensoria=nget("defensoria");
$equipo=nget("equipo");
if($defensoria!="null"){
 $deeq="";
 if($equipo!="null")  {
   $deeq="Eq.".$equipo;
 };
 ejecute("update hogares_admision set admi_deriv_sector=".$defensoria.", admi_deriv_cual=concat(".tsql($deeq).",' ',admi_deriv_cual) where idhogares_admision=".$id);
};
Redirect("admicons");
?>


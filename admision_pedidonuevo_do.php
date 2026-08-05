<?php
include("Funciones.php"); 
session_start();
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
$lega=$_GET["legajo"];
if(isset($_GET["fecha"])) $fped=$_GET["fecha"];
$fped=fsql($_GET["ifped"]);
$deri=$_GET["ideriv"];
$derc=$_GET["iderc"];
$admi=$_GET["admisor"];
$cate=nulea($_GET["icateg"]);
$proc=nulea($_GET["iproced"]);
$prcc=$_GET["iprcc"];
$hosp="0";
if($proc=="10"||$proc=="11") {$hosp=$_GET["hospital"];if($prcc=="") $prcc=un_campo("select descripcion from salud_establecimientos where idsalud_establecimientos=".$hosp);};
$moti=$_GET["imoting"];
$ahos=$_GET["iahos"];
$faho=$_GET["ifaho"];
$obse=$_GET["iobse"];
$halt=nulea($_GET["iahos"]);
$urge=nulea($_GET["iurge"]);
$falt=fsql($_GET["ifaho"]);
if($_GET["ifaho"]==""||$halt=="null")  $falt="null";
$fact=$_GET["ifact"];
$hogar="null";
$fder="null";
$alta="null";
$id=inserte("insert into hogares_admision(admi_legajo, admi_fped, admi_deriv,admi_deriv_cual,admi_admi,admi_cate,admi_proc,admi_proc_cual,admi_moti,admi_obse,admi_usuario,admi_halt,admi_falt,admi_urge,admi_hogar,admi_fderiv,admi_alta,admi_fact,hospital) values(".$lega.", ".$fped.",".$deri.",'".$derc."','".$admi."', ".$cate.", ".$proc.",'".$prcc."', ".$moti.",'".$obse."','".$_SESSION['glusua']."',".$halt.",".$falt.",".$urge.",".$hogar.",".$fder.",".$alta.",'".$fact."',".$hosp.")");

$defensoria=nget("defensoria");

$equipo=nget("equipo");

if($defensoria!="null"){

 $dj = un_registro("select * from sujetos where sujetos.legajo=".$lega);

 
 ejecute("update sujetos set defensoria_zonal=".$defensoria." where not defensoria_zonal>0 and legajo=".$lega);

 $deeq="";

 if($equipo!="null")  {

   ejecute("update sujetos set equipo=".$equipo." where legajo=".$lega);

   $deeq="Eq.".$equipo;

 };

 ejecute("update hogares_admision set admi_deriv_sector=".$defensoria.", admi_deriv_cual=concat(".tsql($deeq).",' ',admi_deriv_cual) where idhogares_admision=".$id);

};

Redirect("admision_pedidogrupo?legajo=".$lega."&id=".$id);

?>


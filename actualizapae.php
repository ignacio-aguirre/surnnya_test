<?php 
include("Funciones.php"); 
session_start();
if (!isset($_SESSION['gldispo'])|!isset($_POST['legajo'])) header ("Location: .");
$legajo=$_POST["legajo"];
if(un_campo("select id from sujetos_pae where legajo=".$legajo)=="") {inserte("insert into sujetos_pae(legajo) values(".$legajo.")");};
$provincia_nacimiento=tpost("provincia_nacimiento");
$documentacion=tpost("documentacion");
$ultmex_fecha=fpost("ultmex_fecha");
$ultmex_nro=tpost("ultmex_nro");
$ultmex_motivo=tpost("ultmex_motivo");
$hijos=npost("hijos");
$nivel_educativo=npost2("nivel_educativo");
$discapacidad=si(isset($_POST["discapacidad"]),"1","0");
$cobro_pension=si(isset($_POST["cobro_pension"]),"1","0");
$cobro_auh=si(isset($_POST["cobro_auh"]),"1","0");
$cobro_otras=si(isset($_POST["cobro_otras"]),"1","0");
$cobro_especificar=tpost("cobro_especificar");
$trabaja=si(isset($_POST["trabaja"]),"1","0");
$laboral_condiciones=tpost("laboral_condiciones");
$laboral_especificar=tpost("laboral_especificar");
$laboral_dinero=npost("laboral_dinero");
$laboral_dinero_obs=tpost("laboral_dinero_obs");
$autovalimiento=npost("autovalimiento");
$proyecto=npost2("proyecto");
$dinero_vivienda=npost2("dinero_vivienda");
$referente_1=npost2("referente_1");
$referente_2=npost2("referente_2");
$intereses=tpost("intereses");
$competencias=tpost("competencias");
ejecute("update sujetos_pae set nivel_educativo=".$nivel_educativo.",discapacidad=".$discapacidad.
",cobro_pension=".$cobro_pension.",cobro_auh=".$cobro_auh.", documentacion=".$documentacion.
",cobro_otras=".$cobro_otras.",cobro_especificar=".$cobro_especificar.
", trabaja=".$trabaja.",laboral_condiciones=".$laboral_condiciones.", laboral_especificar=".$laboral_especificar.", dinero_vivienda=".$dinero_vivienda.
", referente_1=".$referente_1.",referente_2=".$referente_2.", ultmex_fecha=".$ultmex_fecha.", ultmex_nro=".$ultmex_nro.", ultmex_motivo=".$ultmex_motivo.
",provincia_nacimiento=".$provincia_nacimiento.", laboral_dinero=".$laboral_dinero.", laboral_dinero_obs=".$laboral_dinero_obs.
",hijos=".$hijos.", proyecto=".$proyecto.", autovalimiento=".$autovalimiento.", intereses=".$intereses.", competencias=".$competencias." where legajo=".$legajo);

Redirect("suje_cons_pae?legajo=".$legajo);

function npost2($t){
  $re=npost($t);
  if($re=="null"){$re="0";};
  return $re;
};



?>




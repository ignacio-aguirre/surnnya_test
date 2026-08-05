<?php
include("Funciones.php");
session_start(); 
if (!isset($_SESSION['gldispo'])||!isset($_GET['legajo'])) header ("Location: salir");
$paren=$_GET['iparen'];
$apel=$_GET['iapef'];
$nomb=$_GET['inomf'];
$lega=$_GET['legajo'];
$ilega=nulea($_GET['ilega']);
$edad=$_GET['iedaf'];
$actu=$_GET['iactf'];
$vive=$_GET['i_vivf'];
$ocup=$_GET['i_ocuf'];
$obse=$_GET['i_obsf'];
$domi=$_GET['i_domf'];
$tele=$_GET['i_telf'];
$faux="null";

if($actu!="") $faux=fsql($actu);
if (intval($edad)==0||$edad=="") $edad="null";
if ($vive=="") $vive="null";
if($paren=="M") {
$da=un_registro("select fami_paren from sujetos_familia where fami_paren='M' and baja is null and fami_legajo=".$lega);
if($da["fami_paren"]==$paren) $paren="";
};

if($paren=="P") {
$da = un_registro("select fami_paren from sujetos_familia where fami_paren='P' and baja is null and fami_legajo=".$lega);
if($da["fami_paren"]==$paren) $paren="";
};

if ($paren!="") {
$sql="insert into sujetos_familia(fami_legajo, fami_paren, fami_apellidos, fami_nombres, fami_edad, fami_actedad,fami_vive, fami_ocup, fami_obse, fami_domi, fami_tele, alta, fami_lega)";
$sql=$sql." values(".$lega.",'".$paren."', '".$apel."', '".$nomb."', ".$edad.", ".$faux.", ".$vive.",'".$ocup."', '".$obse."', '".$domi."','".$tele."', curdate(),".$ilega.");";
ejecute($sql);
if($ilega!="null"&&$paren=="H") 

{
$origen=un_registro("select apellidos, nombres, edadcalc(fecha_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,curdate()) as edad from sujetos where sujetos.legajo=".$lega);
$yaesta=un_registro("select count(*) as cant from sujetos_familia where fami_legajo=".$ilega." and fami_lega=".$lega);
  if($yaesta["cant"]==0) {
$sql="insert into sujetos_familia(fami_legajo, fami_paren, fami_apellidos, fami_nombres, fami_edad, fami_actedad,fami_vive,alta, fami_lega)";
$sql=$sql." values(".$ilega.",'H', '".$origen["apellidos"]."', '".$origen["nombres"]."', ".nulea($origen["edad"]).", curdate(), 1, curdate(),".$lega.");";
ejecute($sql);
  };
};

if($ilega!="null"&&($paren=="M"|$paren=="P")) 

{
$origen=un_registro("select apellidos, nombres, edadcalc(fecha_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,curdate()) as edad from sujetos where sujetos.legajo=".$lega);
$yaesta=un_registro("select count(*) as cant from sujetos_familia where fami_legajo=".$ilega." and fami_lega=".$lega);
  if($yaesta["cant"]==0) {
$sql="insert into sujetos_familia(fami_legajo, fami_paren, fami_apellidos, fami_nombres, fami_edad, fami_actedad,fami_vive,alta, fami_lega)";
$sql=$sql." values(".$ilega.",'I', '".$origen["apellidos"]."', '".$origen["nombres"]."', ".nulea($origen["edad"]).", curdate(), 1, curdate(),".$lega.");";
ejecute($sql);
  };

};


header('location: '."sujeactfamilia?legajo=".$lega);}

die("Familiar Repetido");

?>

</body>

</html>
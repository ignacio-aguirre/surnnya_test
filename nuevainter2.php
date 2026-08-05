<?PHP
include("Funciones.php");
session_start();
registre();
$fecha=fget("fecha");
$vleg=nulea($_GET['lega']);
$voper=$_GET['oper'];
$vtipo=$_GET['tipo'];
$hosp=nget("hosp");
if($hosp=="0"){$hosp="null";};
$usua=$_SESSION['glusua'];
$vobse=$_GET['obse'];
$todo=$_GET['todo'];
$todohogar=$_GET['todohogar'];
if($fecha>fsql($_SESSION["DiaHoy"])) $fecha=fsql($_SESSION["DiaHoy"]);
$inferior=un_campo("select date_add(curdate(), INTERVAL -30 DAY) from dual");

if($fecha<fsql(ffec($inferior))){$fecha=fsql($_SESSION["DiaHoy"]);};
$sql="insert into intervenciones(inter_fecha, inter_dispo, inter_oper, inter_legajo, inter_tipo, inter_hosp,inter_obse, inter_usuario,fechahora) values (".$fecha.",".$_SESSION['gldispo'].",'".$voper."', ".$vleg.",".$vtipo.",".$hosp.",'".$vobse."','".$usua."',sysdate())";
$id=inserte($sql);

if($todo=="1" and $vleg!="null"){
 $grup=un_campo("select grupo from grupos_legajos where grupo_legajo=".$vleg);
 if($grup!="") $reg=registros("select distinct grupo_legajo from grupos_legajos where grupo=".$grup." and grupo_legajo<>".$vleg);
 while ($le = mysqli_fetch_assoc($reg)) {
   $sql="insert into intervenciones(inter_fecha, inter_dispo, inter_oper, inter_legajo, inter_tipo, inter_hosp, inter_obse, inter_usuario,fechahora) values (curdate(),".$_SESSION['gldispo'].",'".$voper."', ".$le["grupo_legajo"].",".$vtipo.",".$hosp.",'".$vobse."','".$usua."',sysdate())";
   ejecute($sql);}
 };
if($todohogar=="1" and $vleg!="null"){
 $hogar=un_campo("select admi_hogar from hogares_admision where admi_legajo=".$vleg." and admi_alta is not null and admi_baja is null");
 if($hogar!="") $reg=registros("select distinct admi_legajo from hogares_admision where admi_hogar=".$hogar." and admi_alta is not null and admi_baja is null and admi_legajo<>".$vleg);
 while ($le = mysqli_fetch_assoc($reg)) {
   $sql="insert into intervenciones(inter_fecha, inter_dispo, inter_oper, inter_legajo, inter_tipo, inter_hosp, inter_obse, inter_usuario,fechahora) values (curdate(),".$_SESSION['gldispo'].",'".$voper."', ".$le["admi_legajo"].",".$vtipo.",".$hosp.",'".$vobse."','".$usua."',sysdate())";
   ejecute($sql);}
 };

Redirect($_SESSION["menu"]);
?>

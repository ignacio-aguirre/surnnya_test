<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Actualizaci&oacute;n de datos de Sujeto";

if (!isset($_SESSION['gldispo'])) header ("Location: salir");
if (isset($_GET['lega']))
{
$fami=$_GET["fami"];
$lega=$_GET["lega"];
 
$dt=un_registro("select idsujetos_familia, fami_lega from sujetos_familia where idsujetos_familia=".$fami." and baja is not null");
if ($dt["idsujetos_familia"]==$fami) header("Location: ".$_SESSION["menu"]);
$ilega=nulea($dt["fami_lega"]);
ejecute("update sujetos_familia set baja=curdate() where idsujetos_familia=".$fami);

ejecute("insert into sujetos_familia(fami_legajo, fami_paren, alta, fami_lega) values(".$lega.",'X', curdate(),".$ilega.")");

$dt=un_registro("select idsujetos_familia from sujetos_familia where fami_legajo=".$lega." and fami_paren='x' and alta=curdate() and baja is null");
$fami=$dt['idsujetos_familia'];

ejecute("update sujetos_familia set fami_apellidos='".$_GET["iapef"]."' where idsujetos_familia=".$fami);

ejecute("update sujetos_familia set fami_nombres='".$_GET["inomf"]."' where idsujetos_familia=".$fami);

ejecute("update sujetos_familia set fami_paren='".$_GET["iparen"]."' where idsujetos_familia=".$fami);

$edad=$_GET["iedaf"];
if (intval($edad)==0) $edad="null";
ejecute("update sujetos_familia set fami_edad=".$edad." where idsujetos_familia=".$fami);

if($_GET["iactf"]=="") {$actu="null";} else $actu=fsql($_GET["iactf"]);
ejecute("update sujetos_familia set fami_actedad=".$actu." where idsujetos_familia=".$fami); 

$vive=$_GET["i_vivf"];
if($_GET["i_vivf"]=="") $vive="null";

$ilega=nulea($_GET["i_lega"]);

ejecute("update sujetos_familia set fami_lega=".$ilega." where idsujetos_familia=".$fami);

ejecute("update sujetos_familia set fami_vive=".$vive." where idsujetos_familia=".$fami);

ejecute("update sujetos_familia set fami_ocup='".$_GET["i_ocuf"]."' where idsujetos_familia=".$fami);

ejecute("update sujetos_familia set fami_obse='".$_GET["i_obsf"]."' where idsujetos_familia=".$fami);

ejecute("update sujetos_familia set fami_domi='".$_GET["i_domf"]."' where idsujetos_familia=".$fami);

ejecute("update sujetos_familia set fami_tele='".$_GET["i_telf"]."' where idsujetos_familia=".$fami);

if($ilega!="null"&&$_GET["iparen"]=="H") 
{
$origen=un_registro("select apellidos, nombres, edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,curdate()) as edad from sujetos where sujetos.legajo=".$lega);
$yaesta=un_registro("select count(*) as cant from sujetos_familia where fami_legajo=".$ilega." and fami_lega=".$lega);
  if($yaesta["cant"]==0) {
$sql="insert into sujetos_familia(fami_legajo, fami_paren, fami_apellidos, fami_nombres, fami_edad, fami_actedad,fami_vive,alta, fami_lega)";
$sql=$sql." values(".$ilega.",'H', '".$origen["apellidos"]."', '".$origen["nombres"]."', ".nulea($origen["edad"]).", curdate(), 1, curdate(),".$lega.");";
ejecute($sql);

  };

};

Redirect("sujeactfamilia?legajo=".$_GET['lega']);
};
include("encabezado-test.php");
$fami=$_GET["id"];

$dt =un_registro("select * from sujetos_familia inner join sujetos on fami_legajo=legajo where idsujetos_familia=".$fami);
$paren=$dt['fami_paren'];
$sinn="<option value=''>S/I</option><option value='1'>Si</option><option value='0'>No</option>";
$lega=$dt['Legajo'];
$actu=$dt['fami_actedad'];
$vivi=$dt['fami_vive'];
if (gettype($actu)=="NULL") {$actu="";} else $actu=ffec($actu);
if (gettype($vivi)=="NULL") $vivi="";
?>
</div>
<div class='container'>
<form class="form" method="get">
<table align='center'>
<tr><td>Sujeto</td><td><?php echo $dt['Legajo']." ".$dt['Apellidos'].",".$dt['Nombres'];?></td></tr>
<tr><td>Parentesco</td><td><select name='iparen' id='i_paren'><option value="M">Madre</option><option value="P">Padre</option><option value="H">Hermano/a</option><option value="T">Tio/a</option><option value="A">Abuelo/a</option><option value="N">Pareja</option><option value="I">Hijo/a</option><option value="B">Pareja Madre</option><option value="C">Pareja Padre</option><option value="S">Sobrino/a</option><option value="O">Otros</option><option value="">S/D</option></select></td></tr>

<tr><td>Apellidos</td><td><input size='45' maxlength='45' name="iapef" id="i_apef" onblur='valida_0("i_apef")' value='<?php echo $dt['fami_apellidos'];?>'></td></tr>
<tr><td>Nombres</td><td><input size='45' maxlength='45'  name="inomf" id="i_nomf" onblur='valida_0("i_nomf")' value='<?php echo $dt['fami_nombres'];?>'></td></tr>
<tr><td>Edad</td><td><input size='3'  maxlength='3' name="iedaf" id="i_edaf" onblur='valida_entero("iedaf")' value='<?php echo $dt['fami_edad'];?>'></td></tr>
<tr><td>F.Act.</td><td><input size='8'  maxlength='10' name="iactf" id="i_actf" onblur='valida_fecha("iactf")' value='<?php echo $actu;?>'></td></tr>
<tr><td>Vive</td><td><select name='i_vivf' id='ivivf'><?php echo $sinn?></select></td></tr>
<script langtype='text/javascript'>
seleccionar("i_paren","<?php echo $paren;?>");
seleccionar("ivivf","<?php echo $vivi;?>");
enfoca("i_paren");
</script>
<tr><td>Legajo</td><td><input size='6' maxlength='6' name="i_lega" id="i_lega" onblur='valida_0("i_lega")' value='<?php echo $dt['fami_lega'];?>' onblur='valida_entero("i_lega")'></td></tr>
<tr><td>Ocupaci&oacute;n</td><td><input size='45' maxlength='45' name="i_ocuf" id="iocuf" onblur='valida_0("iocuf")' value='<?php echo $dt['fami_ocup'];?>'></td></tr>
<tr><td>Observaciones</td><td><input size='60' maxlength='100'name="i_obsf" id="iobsf" onblur='valida_0("iobsf")' value='<?php echo $dt['fami_obse'];?>'></td></tr>
<tr><td>Domicilio</td><td><input size='60' maxlength='60'name="i_domf" id="idomf" onblur='valida_0("idomf")'  value='<?php echo $dt['fami_domi'];?>'></td></tr>
<tr><td>Tel&eacute;fonos</td><td><input size='45' maxlength='45'name="i_telf" id="itelf" onblur='valida_0("itelf")'  value='<?php echo $dt['fami_tele'];?>'></td></tr>
<input name="fami" type="hidden" value="<?php echo $fami;?>" />    
<input name="lega" type="hidden" value="<?php echo $lega;?>" />    
<tr><td></td><td><input type='submit' name='ienviarf' value='Enviar Datos' /></td></tr>
</table>

</form>
</div>
</body>
</html>
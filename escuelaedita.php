<?php
include("Funciones.php"); 
session_start();
$_SESSION["prestacion"]="Edici&oacute;n Datos Escolares";
include("encabezado-test.php");
if (isset($_GET['lega']))
{
$esco=$_GET["escu"];
ejecute("update sujetos_escuela set esco_nomb='".$_GET["inome"]."' where idsujetos_escuela=".$esco);
$loce=$_GET["iloce"];
if ($loce=="") $loce="null";
ejecute("update sujetos_escuela set esco_loca='".$loce."' where idsujetos_escuela=".$esco);
ejecute("update sujetos_escuela set esco_cuan='".$_GET["icuae"]."' where idsujetos_escuela=".$esco);
ejecute("update sujetos_escuela set esco_nive='".$_GET["inive"]."' where idsujetos_escuela=".$esco);
ejecute("update sujetos_escuela set esco_refe='".$_GET["irefe"]."' where idsujetos_escuela=".$esco);
ejecute("update sujetos_escuela set esco_obse='".$_GET["iobse"]."' where idsujetos_escuela=".$esco);
Redirect("sujeactescuela.php?legajo=".$_GET['lega']);
}; 
$esco=$_GET["id"];
$sql="select * from sujetos_escuela inner join sujetos on esco_legajo=legajo where idsujetos_escuela=".$esco;
$dt = un_registro($sql);
$lega=$dt['Legajo'];
$loce=$dt['esco_loca'];
?>
</div>
<div class="container">
<form method="get" action="escuelaedita">
<table align='center'>
<tr><td>Sujeto</td><td><?php echo $dt['Legajo']." ".$dt['Apellidos'].",".$dt['Nombres'];?></td></tr>
<tr><td>Nombre Escuela</td><td><input size='30' maxlength='45' name="inome" id="i_nome" onblur='valida_0("i_nome")' value='<?php echo $dt["esco_nomb"];?>'></td></tr>
<tr><td>Localidad</td><td><select name='iloce' id='i_loce'><?php echo $_SESSION['loc_gene'];?></select></td>
<tr><td>Cu&aacute;ndo</td><td><input size='20' maxlength='45' name="icuae" id="i_cuae" onblur='valida_0("i_cuae")' value='<?php echo $dt["esco_cuan"];?>'></td></tr>
<tr><td>Ultimo Nivel alcanzado</td><td><input size='20' maxlength='45' name="inive" id="i_nive" onblur='valida_0("i_nive")' value='<?php echo $dt["esco_nive"];?>'></td></tr>
<tr><td>Referente y turno</td><td><input size='30' maxlength='45' name="irefe" id="i_refe" onblur='valida_0("i_refe")' value='<?php echo $dt["esco_refe"];?>'></td></tr>
<tr><td>Observaciones</td><td><input size='30' maxlength='45' name="iobse" id="i_obse" onblur='valida_0("i_obse")' value='<?php echo $dt["esco_obse"];?>' ></td></tr>
<script langtype='text/javascript'>
seleccionar("i_loce","<?php echo $loce;?>");
enfoca("i_nome");
</script>
<input name="escu" type="hidden" value="<?php echo $esco;?>" />    
<input name="lega" type="hidden" value="<?php echo $lega;?>" />    
<tr><td></td><td><input class="btn-primary" type='submit' name='ienviarf' value='Actualizar' /></td></tr>
</table>

</form>
</div>
</body>
</html>
<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Actualizaci&oacute;n Datos Jur&iacute;dicos";
include("encabezado.php");
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
if($_SESSION["gl_editar_sujeto"]==0) header("Location: ".$_SESSION["menu"]);
registre();
$lega= $_GET["legajo"];
if ($lega== "" ) header ("Location: ".$_SESSION["menu"]);
include("mnu_superior.php");
$enca=un_registro("select concat(apellidos,',',nombres) as nomb from sujetos where legajo=".$lega);
$opci2="<option value=''>---Completar</option>";
$conn = registros("select id, denominacion from sectores order by denominacion");
while ($dt = mysqli_fetch_assoc($conn)) {$opci2=$opci2."<option value='".$dt['id']."'>".$dt['denominacion']."</option>";};

$dj = un_registro("select * from sujetos left join sujetos_juridicos on sujetos.legajo=sujetos_juridicos.legajo where sujetos.legajo=".$lega);
if ($dj['legajo']!=$lega) ejecute("insert into sujetos_juridicos (legajo) values(".$lega.")");
$sinn="<option value=''>S/D</option><option value='1'>Si</option><option value='0'>No</option>";
?>

<script langtype='text/javascript'>

function valida_datos() {
if(document.getElementById('jumo').value>0 && (document.getElementById('junu').value==""||document.getElementById('junu').value=="NaN")) {alert("Complete Nro.Juzgado");return false;};
if(document.getElementById('jumo').value=="" && document.getElementById('junu').value>0) {alert("Complete Modalidad Juzgado");return false;};
valida_0("expe");
valida_0("cara");
valida_0("deeq");
return true;
}

</script>
</div>
<div class="container">
<h3><?php echo $enca["nomb"];?> Datos Jur&iacute;dicos</h3>

<form method='post' action='actualizajuridicos' onsubmit='return valida_datos()'>
<h4>Organismos Intervinientes</h4>
<div class="table-responsive">
<table class="table-condensed">
<tr><td>Juzgado</td><td>Nro.</td><td>Expediente</td><td>Car&aacute;tula</td></tr>
<td><select class="form-control" name='jumo' id='jumo'><?php echo tbla('TJ');?></select></td>
<td><input class="form-control" type='text' name='junu' id='junu' size='3' maxlength='3' onblur='valida_entero("junu")' value='<?php echo $dj['juzgado_numero'];?>'></td>
<td><input class="form-control" type='text' name='expe' id='expe' size='30' maxlength='45' onblur='valida_0("expe")' value='<?php echo $dj['juzgado_expediente'];?>'></td>
<td><input class="form-control" type='text' name='cara' id='cara' size='100' maxlength='100' onblur='valida_0("cara")' value='<?php echo $dj['juzgado_caratula'];?>'></td>
</tr>
</table>
</div>
<br>
<div class="table-responsive">
<table class="table-condensed">
<tr><td>Def. Zonal</td><td>Equipo</td><td>Tipo Medida</td><td>Zonal Provincial</td></tr>
<tr><td><select class="form-control" name='dezo' id='dezo' required>
<option value=""></option>
<?php echo opc_tabla('CM');?>
</select></td>
<td><input class="form-control" name='deeq' id='deeq' size='5' maxlength='20' onblur='valida_0(this.id)' value='<?php echo $dj['equipo']?>'></td>
<td><select  class="form-control" name='tmed' id='tmed'><?php echo tbla('TM');?></select></td>
<td><select  class="form-control" name='zpro' id='zpro'><?php echo tbla('ZP');?></select></td></tr>
</table>

<input type="hidden" name="legajo" value="<?php echo $lega;?>">
<input class="btn-primary" type="submit" name="ienviar" value="Enviar Datos">
</form>



<script langtype='text/javascript'>
seleccionar("jumo","<?php echo $dj['juzgado_modalidad'];?>");
seleccionar("dezo","<?php echo $dj['defensoria_zonal'];?>");
seleccionar("tmed","<?php echo $dj['tipo_medida'];?>");
seleccionar("zpro","<?php echo $dj['zonal_provincial'];?>");
</script> 



</div>	 	

</body>



</html>
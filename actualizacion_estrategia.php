<?php
include("Funciones.php");
session_start();
$_SESSION['prestacion']="Actualizaciones de Estrategia de Egreso";
include('encabezado-test.php');
if (!isset($_SESSION['gldispo'])|!isset($_GET['legajo'])) header ("Location: index");
$lega= $_GET["legajo"];
if ($lega=="" ) Redirect("Location: consultasujetos");
$sql="select apellidos, nombres, apodos, sujetos.legajo as lega, tipodni, sujetosdni, f_nacimiento, sujetosedad, sujetosmeses, sujetosactedad, 
 edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,curdate()) as edad,   rib_anio, rib_numero, rib_reparticion, 
 ming1,ming2,ming3,ctex1,ctex2,ctex3,es_egreso ,es_egreso_estado 
 from sujetos  where sujetos.legajo=".$lega;
$dt = un_registro($sql);
$sexo="";
if($dt['sexo']=="F") $sexo="Fem.";
if($dt['sexo']=="M") $sexo="Masc.";
if($dt['sexo']=="X") $sexo="X";
$fnac=ffec($dt['f_nacimiento']);
$ehoy=$dt['edad'];
include("mnu_superior.php");
?>
<div class="container">
<div class="table-responsive">
<table class="table table-striped table-bordered table-condensed">
<thead><tr class="bg-primary"><td>RIB</td><td>Apellidos y Nombres</td><td>Edad Hoy</td></tr></thead>
<tr bgcolor="white"><td><strong><?php echo rib2($dt);?></td><td><strong><?php echo $dt['apellidos'].", ".$dt['nombres'];?></td><td><strong><?php echo $ehoy;?></td></tr>
</table>
</div>

<form class="form-inline">
<div class="form-group has-warning">
<label class="label-form" for="estrategia">Estrategia de Egreso</label>
<select class="form-control" id="estrategia"><?php echo tbla("e_egreso")?></select>
</div><br><br>

<div class="form-group has-warning">
<label class="label-form" for="estado">Estado Actual</label>
<select class="form-control" id="estado"><?php echo tbla("ETEE")?></select>
</div><br><br>

<div class="form-group has-warning">
<label class="label-form" for="acciones">Acciones Realizadas</label>
<input class="form-control" id="acciones" size="100" maxlength="100"></select>
</div><br><br>
</form>
<button class='btn-primary' onclick='agregar()'>Aceptar</button>
</div>

<script>
window.onload=function(){
seleccionar("estrategia","<?php echo $dt['es_egreso'];?>");
seleccionar("estado","<?php echo $dt['es_egreso_estado'];?>");
document.getElementById("estrategia").focus();
}


function agregar(){

if(acciones.value==""){status("Completar Acci&oacute;n");return false;};

navega("actualizacion_estrategia_do?legajo=<?php echo $lega?>&estrategia="+document.getElementById("estrategia").value+"&estado="+document.getElementById("estado").value+"&acciones="+acciones.value);

}

</script>

</body>



</html>
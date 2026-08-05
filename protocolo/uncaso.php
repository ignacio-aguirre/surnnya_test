<?php 
include("funciones.php");
session_start();
$_SESSION["titulo"]="Consulta de un caso";
include("encabezado-test.php");
tranca();
if(isset($_GET["id"])) Redirect("llevaauncaso?id=".$_GET["id"]);
$id=$_SESSION["caso"];
$r=un_registro("select *,edadcalc(fecha_nacimiento,edad,fecha_edad,curdate()) as edc from casos where idcasos=".nulea($id));
?>

<div class="container" align="center">
<h1>Consulta de Datos</h1>
<?php if($_SESSION["escritura"]==1) echo "<a href='editacaso'><img width='25' height='25' src='imagenes/editar.png'>&nbsp;Editar</a>
&nbsp;<a href='javascript:archivacaso()'><img width='25' height='25' src='imagenes/eliminar.png'>&nbsp;Desactivar</a>";?>
</div>
<div class="container">
<div class="table-responsive">
<table class="table table-bordered table-condensed">
<tr class="info">
<th>Apellidos</th><th>Nombres</th><th>F.Nacimiento</th><th>Edad Hoy</th>
</tr>
<?php echo "<tr><td>",$r["apellidos"],"</td><td>",$r["nombres"],"</td><td>",ffec($r["fecha_nacimiento"]),"</td><td>",$r["edc"],"</td></tr>";
?>
</table>
</div>
<div class="table-responsive">
<table class="table table-striped table-bordered table-condensed">
<tr class="info">
<th>Tipo</th><th>Nro.Documento</th><th>Nacionalidad</th><th>J.Civil</th><th>Expediente</th>
</tr>
<?php echo "<tr><td>",$r["tipo_documento"],"</td><td>",$r["numero_documento"],"</td><td>",$r["nacionalidad"],"</td><td>",$r["juzgado"],"</td><td>",$r["expediente"],"</td></tr>";
?>
</table>
</div>
<div class="table-responsive">
<table class="table table-striped table-bordered table-condensed">
<tr class="info">
<th>Defensor</th><th>Equipo/DZ CDNNYA</th><th>Intervenci&oacuten Socio Jur&iacute;dica JNM</th>
</tr>
<?php echo "<tr><td>",$r["defensor"],"</td><td>",$r["cdnnya"],"</td><td>",$r["intervencion_sj"],"</td></tr>";
?>
</table>
</div>
<div class="table-responsive">
<table class="table table-striped table-bordered table-condensed col-md-12">
<tr class="info" class='info col-md-12'>
<th class="col-md-3">TOM</th><th class="col-md-9">Sugerencia de Hospital</th>
</tr>
<?php echo "<tr><td class='col-md-3'>",si($r["tom"]!="0",$r["tom"],""),"</td><td class='col-md-9'>",un_campo("select descripcion from hospitales where idhospitales=".nulea($r["hospital_sugerido"])),
"</td></tr></table></div>";
$alojado=un_registro("select  alojamientos.*, datediff(curdate(),f_ingreso) as perm from alojamientos where caso=".$id." and f_egreso is null");
if($alojado["caso"]==$id){?>
	<div class="table-responsive">
	<table class="table table-striped table-bordered table-condensed col-md-12">
        <tr><th class='info col-md-6'>en dispositivo</th><th class='info col-md-3'>Desde el</th><th class='info col-md-3'>Ds Perm</th></tr>
 	<tr class='info col-md-6'><td>
    <?php echo $alojado['dispositivo']."</td><td>".ffec($alojado['f_ingreso'])."</td><td>".$alojado['perm']."</td></tr>";
	
 }?>

</table>
</div>
<div class="container">
	<button class="btn-sm btn-success" onclick="navega('documentacion')">documentaci&oacute;n</button>
	<button class="btn-sm btn-primary" onclick="navega('acciones')">acciones</button>
	<button class="btn-sm btn-info" onclick="navega('alojamientos')">alojamientos</button>
	<button class="btn-sm btn-secondary" onclick="navega('casos')">casos</button>
	
</div>



<script>
function archivacaso(){
 if(confirm("Seguro/a de desactivar este caso?")){	
	id="<?php echo $id;?>";
	navega("archivacaso?id="+id);
 };	
	return true;
};	
</script>
</body>
</html>


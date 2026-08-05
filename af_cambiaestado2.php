<?php 
include("Funciones.php");
session_start();
$id=$_GET["id"];
$r=un_registro("select * from af_familias where idaf_familias=".$id);
$_SESSION["prestacion"]="Registrar cambio de estado 2 familia ".$r["denominacion"];
include("encabezado.php");
?>
</div>
<div class="container">
	<form class="form-inline" method="GET" action="af_cambiaestado2_do" onsubmit="return valida()">
		<div class="form-group has-warning">
			<label for="estado_actual" class="label-form">Estado Actual</label>
			<input class="form-control" disabled id="estado_actual" value="<?php echo estado2($r['tipo_prestacion'])?>">
		</div>
		<div class="form-group has-warning">
			<label for="fecha_actual" class="label-form">Desde el</label>
			<input class="form-control" disabled id="fecha_actual" value="<?php echo ffec($r['fecha_estado2'])?>">
		</div>
		<br><br>
		<div class="form-group has-warning">
			<label for="estado1" class="label-form">Nuevo Estado</label>
			<select class="form-control" id="estado2" name="estado2">
				<?php 
				if($r["tipo_prestacion"]!="1" ){
				echo "<option value='1'>Disponible acogimiento</option>";};
				if($r["tipo_prestacion"]!="2" ){
				echo "<option value='2'>Disponible apoyo</option>";};
				if($r["tipo_prestacion"]!="3" ){
				echo "<option value='3'>Disponible acogimiento y apoyo</option>";};
				if($r["tipo_prestacion"]!="4" ){
				echo "<option value='4'>Acogimiento</option>";};
				if($r["tipo_prestacion"]!="5" ){
				echo "<option value='5'>Apoyo</option>";};
				if($r["tipo_prestacion"]!="6" ){
				echo "<option value='6'>Acogimiento y apoyo</option>";};
				if($r["tipo_prestacion"]!="7" ){
				echo "<option value='7'>Acogimiento con disponibilidad de apoyo</option>";};
				if($r["tipo_prestacion"]!="8" ){
				echo "<option value='8'>Apoyo con disponibilidad de acogimiento</option>";};
				if($r["tipo_prestacion"]!="9" ){
				echo "<option value='9'>Pausa</option>";};
				if($r["tipo_prestacion"]!="10"){
				echo "<option value='10'>Observada</option>";};
				if($r["tipo_prestacion"]!="11"){
				echo "<option value='11'>Baja</option>";};
			?>
			</select>
		</div>
		<div class="form-group has-warning">
			<label for="fecha_estado2" class="label-form">Desde el</label>
			<input class="form-control" id="fecha_estado2" name="fecha_estado2" size="10" maxlength="10" onblur="valida_fechaestado2(this.id)">
		</div>
		<input hidden name="id" value="<?php echo $id?>">
		<button class="btn-primary" type="submit">Actualizar</button>	
	</form>
		
</div>
<script>
function valida(){
	if(!valida_fechaestado2("fecha_estado1")){return false;};
	return true;
}
function valida_fechaestado2(id){
	valida_fecha(id,1);
	if(document.getElementById(id).value==""){return false;};
	if(fsql(document.getElementById(id).value)>fsql("<?php echo $_SESSION['DiaHoy']?>")){alert("la fecha no puede ser futura");document.getElementById(id).value="";return false;};
	if(fsql(document.getElementById(id).value)<fsql("<?php echo ffec($r['fecha_estado2'])?>")){alert("la fecha no puede ser anterior a la del último cambio");document.getElementById(id).value="";return false;};
	return true;
}
enfoca("estado2");
</script>
</body>
</html>
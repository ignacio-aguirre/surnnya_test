<?php 
include("Funciones.php");
session_start();
$id=$_GET["id"];
$r=un_registro("select * from af_familias where idaf_familias=".$id);
$_SESSION["prestacion"]="Registrar cambio de estado 1 familia ".$r["denominacion"];
include("encabezado-test.php");
?>
</div>
<div class="container">
	<form class="form-inline" method="GET" action="af_cambiaestado1_do" onsubmit="return valida()">
		<div class="form-group has-warning">
			<label for="estado_actual" class="label-form">Estado Actual</label>
			<input class="form-control" disabled id="estado_actual" value="<?php echo estado1($r['estado1'])?>">
		</div>
		<div class="form-group has-warning">
			<label for="fecha_actual" class="label-form">Desde el</label>
			<input class="form-control" disabled id="fecha_actual" value="<?php echo ffec($r['fecha_estado1'])?>">
		</div>
		<br><br>
		<div class="form-group has-warning">
			<label for="estado1" class="label-form">Nuevo Estado</label>
			<select class="form-control" id="estado1" name="estado1">
				<option value="1">Admitida</option>
				<option value="3">Con Evaluaci&oacute;n Negativa</option>
				<option value="4">Desisti&oacute;</option>
				
			</select>
		</div>
		<div class="form-group has-warning">
			<label for="fecha_estado1" class="label-form">Desde el</label>
			<input class="form-control" id="fecha_estado1" name="fecha_estado1" size="10" maxlength="10" onblur="valida_fechaestado1(this.id)">
		</div>
		<input hidden name="id" value="<?php echo $id?>">
		<button class="btn-primary" type="submit">Actualizar</button>	
	</form>
		
</div>
<script>
function valida(){
	if(!valida_fechaestado1("fecha_estado1")){return false;};
	return true;
}
function valida_fechaestado1(id){
	valida_fecha(id,1);
	if(document.getElementById(id).value==""){return false;};
	if(fsql(document.getElementById(id).value)>fsql("<?php echo $_SESSION['DiaHoy']?>")){alert("la fecha no puede ser futura");document.getElementById(id).value="";return false;};
	if(fsql(document.getElementById(id).value)<fsql("<?php echo ffec($r['fecha_estado1'])?>")){alert("la fecha no puede ser anterior a la del último cambio");document.getElementById(id).value="";return false;};
	return true;
}
enfoca("estado1");
</script>
</body>
</html>
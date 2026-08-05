<?php
include("Funciones.php"); 
session_start();
$_SESSION['prestacion']="Nueva versión";
include("encabezado-test.php");
$entorno=un_campo("select entorno from parametros");
$modulo="SURNNYA";
$ver=un_registro("select * from versiones where modulo=".tsql($modulo)." and entorno=".tsql($entorno));
?>
<div class="container">
	<form class="form" method="get" action="version_nueva_do">
		<div class="form-group has-warning">
			<label class="label-form">M&oacute;dulo</label>
			<input class="form-control" name="modulo" maxlength="15" required value="<?php echo $modulo?>">
		</div>
		<div class="form-group has-warning">
			<label class="label-form">Entorno</label>
			<input class="form-control" name="entorno" maxlength="8" required value="<?php echo $entorno?>">
		</div>
		<div class="form-group has-warning">
			<label class="label-form">Ver_1</label>
			<input class="form-control" name="ver_1" maxlength="3" required value="<?php echo $ver['ver_1']?>" type="number" min="0" max="99">	
		</div>	
		<div class="form-group has-warning">
			<label class="label-form">Ver_2</label>
			<input class="form-control" name="ver_2" maxlength="3" required value="<?php echo $ver['ver_2']?>" type="number" min="0" max="99">	
		</div>	
		<div class="form-group has-warning">
			<label class="label-form">Ver_3</label>
			<input class="form-control" name="ver_3" maxlength="3" required value="<?php echo $ver['ver_3']?>" type="number" min="0" max="99">	
		</div>	
		<div class="form-group has-warning">
			<label class="label-form">Fecha</label>
			<input type="date" class="form-control" name="fecha" required value="<?php echo $_SESSION["DiaHoy"]?>">
		</div>
		<div class="form-group has-warning">
			<label class="label-form">Cambios</label>
			<textarea name="cambios" class="form_control" cols="80" rows="5" required></textarea>
		</div>	
		<button class="btn-primary">Agregar</button>	
	</form>
</div>	
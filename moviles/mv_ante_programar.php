<?php
session_start();
include("funciones.php");
$_SESSION["prestacion"]="Agregar viaje programado";
include("encabezado.php");
?>
<div class="container">
	<form class="form" action="mv_ante_programar_do" method="get">
		<div class="form-group has-warning">
			<label class="label-form">Tipo solicitante</label>
			<select class="form-control" id="tipo_solicitante" name="tipo_solicitante" required autofocus onblur="solicitantes()">
				<option value="d">Dispositivo</option>
				<option value="s">Sector</option>
			</select>
		</div>
		<div class="form-group has-warning">
			<label class="label-form">Solicitante</label>
			<select class="form-control" id="solicitante" name="solicitante" required>
			</select>
		</div>
		<script>
			function solicitantes(){
			ts=document.getElementById("tipo_solicitante").value;
			if(ts=="s"){
				document.getElementById("solicitante").innerHTML=eje("val_sectores");
			}
			else{
				document.getElementById("solicitante").innerHTML=eje("val_dispositivos");
			}
			return true;
		}

		</script>
		<div class="form-group has-warning">
			<button class="btn-success">Continuar</button>
		</div>
	</form>
</div>
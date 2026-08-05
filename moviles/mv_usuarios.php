<?php
session_start();
include("funciones.php");
$_SESSION["prestacion"]="Usuarios de dispositivos conveniados";
include("encabezado.php");
?>
</div>
<br><br>
<div class="container">
	<form class="form" method="get" action="mv_usuarios_do" onsubmit="return document.getElementById('dispositivo').value>0">
		<div class=form-group has-warning">
			<label class="label-form">Dispositivo</label>
			<select class="form-control" name="dispositivo" id="dispositivo">
			<?php 
			  $dis=registros("select id, nombre from dispositivos where direccion_operativa in(1,2) and ong>0 order by nombre");
			  while ($d=mysqli_fetch_assoc($dis)){
			  	echo "<option value=".$d["id"].">".$d["nombre"]."</option>";
			  }
			?>
                        </select>
		</div>
		<hr>
		<input name="consulta" class="btn-primary" type="submit" value="Consultar">&nbsp;&nbsp;
	</form>
	<button class="btn-success" onclick="navega('mv_usuarios_excel')">Excel</button>
</div>
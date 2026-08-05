<?php
include("Funciones.php");
session_start();
include("encabezado-test.php");
?>
</div>
<div class="container">
	<form class="form" method="get" action="usuarios_hogares_do" onsubmit="return document.getElementById('hogar').value>0">
		<div class=form-group has-warning">
			<label class="label-form">Dispositivo</label>
			<select class="form-control" name="hogar" id="hogar">
			<?php echo $_SESSION["Opc_Hoga"]?>
                        </select>
		</div>
		<hr>
		<input name="consulta" class="btn-primary" type="submit" value="Consultar">&nbsp;&nbsp;
	</form>
	<button class="btn-success" onclick="navega('usuarios_hogares_excel')">Excel</button>
</div>
</body>
</html>